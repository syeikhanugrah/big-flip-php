<?php

namespace Flip\Service;

use Flip\Client;

abstract class AbstractService
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var array|string
     */
    private $services;

    public function __construct($client)
    {
        $this->client = $client;
        $this->services = [];
    }

    /**
     * @return Client
     */
    protected function getClient()
    {
        return $this->client;
    }

    /**
     * @param $method string
     * @param $url string
     * @param array $params
     *
     * @return array
     */
    protected function request($method, $url, $params = [])
    {
        return $this->getClient()->request($method, $url, $params);
    }
}
