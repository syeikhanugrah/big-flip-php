<?php

namespace Flip\Service;

class GeneralService extends AbstractService
{
    /**
     * @return array
     */
    public function getBalance()
    {
        return $this->request('GET', '/general/balance')['balance'];
    }

    /**
     * @param string $bank
     *
     * @return array
     */
    public function getBankInfo($bank = '')
    {
        return $this->request('GET', '/general/banks', [
            'code' => $bank,
        ]);
    }

    /**
     * @return bool
     */
    public function isOperational()
    {
        return $this->request('GET', '/general/operational')['operational'];
    }

    /**
     * @return bool
     */
    public function isMaintenance()
    {
        return $this->request('GET', '/general/maintenance')['maintenance'];
    }
}
