<?php

namespace Flip\Service;

class DisbursementService extends AbstractService
{
    /**
     * @param string $accountNumber
     * @param string $beneficiaryBank
     * @param int $amount
     * @param string $remark
     * @param null $recipientCity
     *
     * @return array
     */
    public function create($accountNumber, $beneficiaryBank, $amount, $remark = '', $recipientCity = null)
    {
        return $this->request('POST', '/disbursement', [
            'account_number' => $accountNumber,
            'bank_code' => $beneficiaryBank,
            'amount' => $amount,
            'remark' => $remark,
            'recipient_city' => $recipientCity,
        ]);
    }

    /**
     * @param string $accountNumber
     * @param string $bank
     *
     * @return array
     */
    public function accountInquiry($accountNumber, $bank)
    {
        return $this->request('POST', '/disbursement/bank-account-inquiry', [
            'account_number' => $accountNumber,
            'bank_code' => $bank,
        ]);
    }
}
