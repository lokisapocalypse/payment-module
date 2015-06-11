<?php

namespace Fusani\Payment\Domain\Model\Transaction;

use Fusani\Payment\Domain\Model\Customer;

class Transaction
{
    protected $amount;
    protected $braintreeId;
    protected $creditCard;
    protected $customer;

    public function __construct($amount, Customer\Customer $customer, CreditCard $creditCard)
    {
        $this->amount = $amount;
        $this->customer = $customer;
        $this->creditCard = $creditCard;
    }

    public function provideBraintreeInterest()
    {
        return [
            'amount' => $this->amount,
            'creditCard' => $this->creditCard->provideBraintreeInterest(),
            'customer' => $this->customer->provideBraintreeInterest(),
        ];
    }

    public function setBraintreeId($braintreeId)
    {
        $this->braintreeId = $braintreeId;
    }
}
