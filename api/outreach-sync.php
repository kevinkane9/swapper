<?php

namespace Sapper\Api;

use Sapper\Db;

class OutreachSync {

    private $cosmosDb;
    private $client;
    private $outreachAccount;
    private $outreachAccountId;
    private $params = [];
    private $outreachEntities = [

        /*[//  accounts
            'outreachEntity' => 'accounts',
            'sapperEntity'   => 'company',
            'filterColumn'   => 'updatedAt'
        ],
        [//  events
            'outreachEntity' => 'events',
            'sapperEntity'   => 'event',
            'filterColumn'   => 'createdAt'
        ],
        [//  mailings
            'outreachEntity' => 'mailings',
            'sapperEntity'   => 'mailing',
            'filterColumn'   => 'updatedAt'
        ],
        [//  mailboxes
            'outreachEntity' => 'mailboxes',
            'sapperEntity'   => 'mailbox',
            'filterColumn'   => 'updatedAt'
        ],*/
        [//  prospects
            'outreachEntity' => 'prospects',
            'sapperEntity'   => 'prospect',
            'filterColumn'   => 'updatedAt',
            'entityIndex'    => 4
        ],
        /*[//  sequences
            'outreachEntity' => 'sequences',
            'sapperEntity'   => 'sequence',
            'filterColumn'   => 'updatedAt'
        ],
        [//  sequenceSteps
            'outreachEntity' => 'sequenceSteps',
            'sapperEntity'   => 'sequence-step',
            'filterColumn'   => 'updatedAt'
        ],
        [//  sequenceTemplates
            'outreachEntity' => 'sequenceTemplates',
            'sapperEntity'   => 'sequence-template',
            'filterColumn'   => 'updatedAt'
        ],
        [//  stages
            'outreachEntity' => 'stages',
            'sapperEntity'   => 'stage',
            'filterColumn'   => 'updatedAt'
        ],
        [//  templates
            'outreachEntity' => 'templates',
            'sapperEntity'   => 'template',
            'filterColumn'   => 'updatedAt'
        ],
        [//  users
            'outreachEntity' => 'users',
            'sapperEntity'   => 'user',
            'filterColumn'   => 'updatedAt'
        ]*/
    ];

    /**
     * @param $outreachAccountId
     * @throws \Exception
     */
    public function __construct($outreachAccountId)
    {
        // setup outreach account & client
        $this->outreachAccountId = $outreachAccountId;
        $this->loadOutreachAccount();
        $this->client = Db::fetchById('sap_client', $this->outreachAccount['client_id']);

        // setup mongo connection
        $this->cosmosDb = new CosmosDbProvider('SapperSuite-Prod');
    }

    /**
     * @throws \Exception
     */
    private function loadOutreachAccount()
    {
        $outreachAccount = Db::fetchById('sap_client_account_outreach', $this->outreachAccountId);

        if (!is_array($outreachAccount) || empty($outreachAccount)) {
            throw new \Exception('Outreach account not found');
        }

        $this->outreachAccount = $outreachAccount;
    }

    private function setFilterParamToMaxValueFromMongo($entity)
    {
        $response = $this->cosmosDb->query(
            sprintf(
                'SELECT VALUE MAX(p.data.attributes.%s) FROM p WHERE p.sapper.outreach_account_id = @accountId',
                $entity['filterColumn']
            ),
            ['@accountId' => $this->outreachAccountId]
        );

        if ('success' == $response['status']) {
            if (count($response['result'])) {
                $this->params["filter[{$entity['filterColumn']}]"] = $response['result'][0] .'..inf';
            } else {
                unset($this->params["filter[{$entity['filterColumn']}]"]);
            }
        } else {
            throw new \Exception($response['error']);
        }
    }

    private function getShardValue($entity, $row)
    {
        return $this->outreachAccountId . $entity['entityIndex'] . $row['id'];
    }

    public function sync()
    {
        $sapperData = [
            'client_id'   => $this->client['id'],
            'client_name' => $this->client['name'],
            'outreach_account_id'    => $this->outreachAccount['id'],
            'outreach_account_email' => $this->outreachAccount['email']
        ];

        foreach ($this->outreachEntities as $entity) {

            // refresh Outreach account in case access token was updated
            $this->loadOutreachAccount();

            $this->cosmosDb->setCollection('outreach-'. $entity['sapperEntity']);
            $page             = 0;
            $rowsRemaining    = false;
            $this->params = [
                'page[limit]' => 100,
                'sort'        => $entity['filterColumn'],
            ];

            $this->setFilterParamToMaxValueFromMongo($entity);

            do {
                $this->params['page[offset]'] = $page*100;

                $attempt = 1;

                doOutreachApiAttempt:
                $response = Outreach::call(
                    $entity['outreachEntity'],
                    $this->params,
                    $this->outreachAccount['access_token'],
                    'get',
                    Outreach::URL_REST_v2
                );

                if ('error' == $response['status'] && 'Invalid access token' == $response['error']) {
                    $this->loadOutreachAccount();

                    $response = Outreach::call(
                        $entity['outreachEntity'],
                        $this->params,
                        $this->outreachAccount['access_token'],
                        'get',
                        Outreach::URL_REST_v2
                    );

                    if ('error' == $response['status'] && 'Invalid access token' == $response['error']) {
                        throw new \Exception('Invalid access token');
                    }
                } elseif ('error' == $response['status']) {

                    if (/*false !== strpos($response['error'], '502 Bad Gateway')
                        || false !== strpos($response['error'], 'internalServerError')
                        || false !== strpos($response['error'], 'Request rate is large')
                        || false !== strpos($response['error'], 'Cross partition query with TOP')*/
                        true
                    ) {
                        if (2 == $attempt) {
                            throw new \Exception($response['error']);
                        } else {
                            $attempt++;
                            sleep($attempt*3);
                            goto doOutreachApiAttempt;
                        }
                    }

                    throw new \Exception($response['error']);
                }

                if ('success' == $response['status']) {

                    foreach($response['data']['data'] as $row) {

                        // remove links
                        if (array_key_exists('links', $row)) {
                            unset($row['links']);
                        }

                        // remove empty & linked relationships
                        if (array_key_exists('relationships', $row)) {
                            foreach ($row['relationships'] as $key => $relationship) {

                                if (array_key_exists('links', $relationship)) {
                                    unset($row['relationships'][$key]['links']);
                                }

                                if (!array_key_exists('data', $relationship)
                                    || (array_key_exists('data', $relationship) && empty($relationship['data']))
                                ) {
                                    unset($row['relationships'][$key]);
                                }
                            }
                        }

                        // add sapper data
                        $shardValue = $this->getShardValue($entity, $row);
                        $document   = [
                            'id'     => $shardValue,
                            'data'   => $row,
                            'sapper' => array_merge(
                                $sapperData,
                                ['shard_key' => $shardValue]
                            )
                        ];

                        $this->cosmosDb->upsert($document);
                    }

                    $rowsRemaining = (($page*100) + count($response['data']['data'])) < $response['data']['meta']['count'];

                    /*
                     * Max allowed value for offset in Outreach API is 10,000
                     * If we reach the max, we filter the timestamp column by the
                     * most recently updated row, and return page/offset to 0
                     */
                    if (99 == $page) {
                        $this->setFilterParamToMaxValueFromMongo($entity);
                        $page = 0;
                    } else {
                        $page++;
                    }
                }

            } while ($rowsRemaining);
        }
    }
}