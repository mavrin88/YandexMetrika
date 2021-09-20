<?php

namespace API\YaMetrika\Service;

use API\YaMetrika\Exceptions\YaMetrikaException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;

class AbstractService
{
    /**
     * Send Request
     *
     * @param $url
     *
     * @return array
     * @throws YaMetrikaException
     */
    protected function query($url)
    {
        try {
            $client = new GuzzleClient($this->getHttpClientParams());
            $response = $client->request('GET', $url);
            $result = json_decode($response->getBody(), true);

            return $result;

        } catch (ClientException $e) {
            throw new YaMetrikaException($e->getMessage());
        }
    }
}
