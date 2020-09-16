<?php

namespace Flip;

use Flip\Service\AbstractService;
use Flip\Service\DisbursementService;
use Flip\Service\GeneralService;

/**
 * Factories used to expose service
 *
 * Service factories serve two purposes:
 *
 * 1. Expose properties for all services through the `__get()` magic method.
 * 2. Lazily initialize each service instance the first time the property for a given service is used.
 */
class ServiceFactory
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $services;

    /**
     * @param Client $client
     */
    public function __construct($client)
    {
        $this->client = $client;
        $this->services = [];
    }

    /**
     * @return array
     */
    public function serviceClassMap()
    {
        return [
            'disbursement' => DisbursementService::class,
            'general' => GeneralService::class,
        ];
    }

    /**
     * @param string $name
     *
     * @return string|null
     */
    protected function getServiceClass($name)
    {
        return array_key_exists($name, $this->serviceClassMap()) ? $this->serviceClassMap()[$name] : null;
    }

    /**
     * @param string $name
     *
     * @return AbstractService
     */
    public function __get($name)
    {
        $serviceClass = $this->getServiceClass($name);
        if ($serviceClass !== null) {
            if (!array_key_exists($name, $this->services)) {
                $this->services[$name] = new $serviceClass($this->client);
            }

            return $this->services[$name];
        }

        throw new \InvalidArgumentException('The service you\'re trying access not exist!');
    }
}
