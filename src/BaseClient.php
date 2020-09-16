<?php

namespace Flip;

use InvalidArgumentException;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

class BaseClient
{
    const PRODUCTION_BASE_URL = 'https://big.flip.id/api/v2';
    const SANDBOX_BASE_URL = 'https://sandbox.flip.id/api/v2';

    private $config;
    private $httpClient;

    private static $defaultConfig = [
        'secret_key' => null,
        'sandbox' => false,
    ];

    public function __construct($config = [])
    {
        $config = array_merge(self::$defaultConfig, $config);
        $this->validateConfig($config);

        $this->config = $config;
        $this->httpClient = new CurlHttpClient();
    }

    /**
     * @return string
     */
    public function getSecretKey()
    {
        return $this->config['secret_key'];
    }

    /**
     * @return string
     */
    public function getApiBaseUrl()
    {
        return $this->config['sandbox'] ? self::SANDBOX_BASE_URL : self::PRODUCTION_BASE_URL;
    }

    /**
     * @param string $method
     * @param string $path
     * @param array $params
     *
     * @return array
     */
    public function request($method, $path, $params = [])
    {
        $url = $this->getApiBaseUrl() . $path;

        $options = [
            'auth_basic' => [$this->getSecretKey(), null],
        ];

        try {
            if (empty($params)) {
                return $this->httpClient->request($method, $url, $options)->toArray();
            }

            if ($method === 'GET') {
                $options['query'] = $params;
            }

            if ($method === 'POST') {
                $options['body'] = $params;
            }

            return $this->httpClient->request($method, $url, $options)->toArray();
        } catch (ExceptionInterface $e) {
            throw new \RuntimeException('There\'s an error with your request. Make sure your public IP/Key Pair are added or contact Flip Developer.');
        }
    }

    /**
     * @param array $config
     *
     * @throws InvalidArgumentException
     */
    private function validateConfig($config)
    {
        if ($config['secret_key'] === null) {
            throw new InvalidArgumentException('secret_key required');
        }

        if (!is_string($config['secret_key'])) {
            throw new InvalidArgumentException('secret_key must be string');
        }
    }
}
