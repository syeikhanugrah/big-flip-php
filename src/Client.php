<?php

namespace Flip;

use Flip\Service\AbstractService;
use Flip\Service\DisbursementService;
use Flip\Service\GeneralService;

/**
 * Client used to send requests to Flip API.
 *
 * @property DisbursementService $disbursement
 * @property GeneralService $general
 */
class Client extends BaseClient
{
    /**
     * @var ServiceFactory
     */
    private $serviceFactory;

    /**
     * @param string $name
     *
     * @return AbstractService|null
     */
    public function __get($name)
    {
        if ($this->serviceFactory === null) {
            $this->serviceFactory = new ServiceFactory($this);
        }

        return $this->serviceFactory->__get($name);
    }
}
