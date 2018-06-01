<?php

namespace Sapper\Api;

class CosmosDbProvider
{
    const BASE_URL        = 'http://localhost:3939/';
    const ENDPOINT_QUERY  = 'query';
    const ENDPOINT_UPSERT = 'upsert';
    const METHOD_POST     = 'post';
    const METHOD_GET      = 'get';

    /** @var string */
    private $database;

    /** @var string */
    private $collection = null;

    /**
     * ProsperworksProvider constructor.
     */
    public function __construct($database, $collection = null)
    {
        $this->database = $database;

        if (null !== $collection) {
            $this->setCollection($collection);
        }
    }

    public function setCollection($collection)
    {
        $this->collection = $collection;
    }

    public function query($query, $params=[])
    {
        return $this->call(
            self::ENDPOINT_QUERY,
            [
                'query'  => $query,
                'params' => $params
            ]
        );
    }

    public function upsert($document)
    {
        return $this->call(
            self::ENDPOINT_UPSERT,
            ['document' => $document]
        );
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
        if (null == $this->collection) {
            throw new \Exception('Collection not defined');
        }

        $urlParams = json_encode(
            array_merge(
                $data,
                [
                    'database' => $this->database,
                    'collection' => $this->collection
                ]
            )
        );
        $ch = curl_init();

        $options = [
            CURLOPT_HTTPHEADER     => ['Content-type: application/json'],
            CURLOPT_URL            => self::BASE_URL . $endpoint,
            CURLOPT_HEADER         => false,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
        ];

        switch ($method) {
            case self::METHOD_POST:
                $options[CURLOPT_POSTFIELDS] = $urlParams;
                break;

            case self::METHOD_GET:
                $options[CURLOPT_URL]    .= '?'. $urlParams;
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


}