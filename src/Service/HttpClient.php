<?php

namespace API\YaMetrika\Service;

use API\YaMetrika\Exceptions\YaMetrikaException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;


class HttpClient
{
    private $client;

    public function __construct($token)
    {
        $this->client = new GuzzleClient($this->getHttpClientParams($token));
    }

    /**
     * Send Request
     *
     * @param $url
     *
     * @return array
     * @throws YaMetrikaException
     */
    public function query($url)
    {
        try {
            $response = $this->client->request('GET', $url);
            $result = json_decode($response->getBody(), true);

            return $result;

        } catch (ClientException $e) {
            throw new YaMetrikaException($e->getMessage());
        }
    }

    /**
     * Getting an array of request parameters for the HTTP client.
     *
     * @return array
     */
    private function getHttpClientParams($token)
    {
        $params = [
            RequestOptions::HEADERS => [
                "Authorization" => "OAuth {$token}"
            ]
        ];

        return $params;
    }
}
