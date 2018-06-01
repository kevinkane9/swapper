<?php
namespace Sapper\Api;

use Sapper\CosmosDb;

class ProsperworksProvider
{
    // 200 is the highest possible value
    const RESULTS_PER_QUERY           = 200;
    const BASE_URL                    = 'https://api.prosperworks.com/developer_api/v1/';
    const COMAPNY_COLLECTION          = 'prosperworks-company';
    const ENDPOINT_COMPANIES_SEARCH   = 'companies/search';
    const ENDPOINT_CUSTOM_DEFINITIONS = 'custom_field_definitions';
    const METHOD_POST                 = 'post';
    const METHOD_GET                  = 'get';

    /**
     * @var
     */
    var $headers;

    /**
     * @var
     */
    var $mongoDatabase;

    /**
     * @var ProsperworksProvider
     */
    var $instance;

    /** @var array */
    var $customDefinitions = [];

    /**
     * ProsperworksProvider constructor.
     */
    public function __construct()
    {
        $headers = [
            'Content-Type'     => 'application/json',
            'X-PW-AccessToken' => $GLOBALS['sapper-env']['PROSPERWORKS_ACCESS_TOKEN'],
            'X-PW-Application' => 'developer_api',
            'X-PW-UserEmail'   => $GLOBALS['sapper-env']['PROSPERWORKS_EMAIL'],
        ];

        $this->headers = $this->formatHeaders($headers);

        $this->mongoDatabase = CosmosDb::getDatabase();

    }

    /**
     * @return ProsperworksProvider
     */
    public static function getInstance()
    {
        if (empty($instance)) {
            $instance = new ProsperworksProvider();
        }

        return $instance;
    }

    /**
     * @param $endpoint
     * @param array $data
     * @param string $method
     * @return mixed
     * @throws \Exception
     */
    protected function call($endpoint, $data = [], $method = self::METHOD_POST)
    {
        $ch = curl_init();

        $options = [
            CURLOPT_HTTPHEADER     => $this->headers,
            CURLOPT_URL            => self::BASE_URL . $endpoint,
            CURLOPT_HEADER         => false,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
        ];

        switch ($method) {
            case self::METHOD_POST:
                $options[CURLOPT_POSTFIELDS] = json_encode($data);
                break;

            case self::METHOD_GET:
                $options[CURLOPT_URL]    .= '?'. http_build_query($data);
                $options[CURLOPT_POST]    = 0;
                $options[CURLOPT_HTTPGET] = 1;
                break;

            default:
                throw new \Exception('Unsupported http method');
                break;
        }

        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response, true);
    }

    /**
     * @param array $headers
     * @return array|string
     */
    private function formatHeaders(array $headers)
    {
        if (empty($headers)) {
            return '';
        }

        $headers_array = array();
        foreach ($headers as $key => $val) {
            $headers_array[] = $key . ': ' . $val;
        }
        return $headers_array;
    }

    /**
     * @param int $page
     * @return mixed
     * @throws \Exception
     */
    public function getCompanies($page = 1)
    {
        return $this->call(
            self::ENDPOINT_COMPANIES_SEARCH,
            [
                'sort_by'        => 'date_modified',
                'sort_direction' => 'desc',
                'page_size'      => self::RESULTS_PER_QUERY,
                'page_number'    => $page,
            ]
        );
    }

    /**
     * @param $company
     * @throws \Exception
     */
    public function storeCompanyInMongo($company)
    {
        CosmosDb::mongoCall(
            $this->getCompanyCollection(),
            'findOneAndReplace',
            [
                ['id' => $company['id']],
                $company,
                ['upsert' => true]
            ]
        );
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getCompaniesFromMongo()
    {
        return CosmosDb::mongoCall(
            $this->getCompanyCollection(),
            'find',
            [
                [],
                [
                    'projection' => [
                        'id' => 1,
                        'name' => 1,
                    ],
                    'sort' => [
                        'name' => 1
                    ]
                ]
            ]
        );
    }

    /**
     * @return \MongoDB\Collection
     */
    private function getCompanyCollection()
    {
        return $this->mongoDatabase->selectCollection(self::COMAPNY_COLLECTION);
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function getCustomDefinitions()
    {
        foreach ($this->call(self::ENDPOINT_CUSTOM_DEFINITIONS, [], self::METHOD_GET) as $definition) {
            if (!array_key_exists('id', $definition)) {
                continue;
            }

            if (!array_key_exists($definition['id'], $this->customDefinitions)) {
                $data = ['name' => $definition['name'], 'options' => []];

                foreach ($definition['options'] as $option) {
                    $data['options'][$option['id']] = $option;
                }

                $this->customDefinitions[$definition['id']] = $data;
            }
        }
    }

    /**
     * @param $fieldId
     * @param null $optionId
     * @return array
     * @throws \Exception
     */
    public function translateCustomDefinition($fieldId, $optionId)
    {
        if (empty($this->customDefinitions)) {
            $this->getCustomDefinitions();
        }
        
        // return null if field not found
        if (!empty($optionId) && !array_key_exists($fieldId, $this->customDefinitions)) {
            return [null, null];
        }



        // return original value if no translation available
        if (!empty($optionId)) {

            $optionId = (string) $optionId;

            if (!array_key_exists($optionId, $this->customDefinitions[$fieldId]['options'])) {
                return [
                    $this->customDefinitions[$fieldId]['name'],
                    ['name' => $optionId]
                ];
            }
        }

        return [
            $this->customDefinitions[$fieldId]['name'],
            $this->customDefinitions[$fieldId]['options'][$optionId]
        ];
    }
}
