<?php

namespace Fusani\Payment\Domain\Model\Transaction;

use Fusani\Payment\Domain\Model\Customer;

class Transaction
{
    protected $amount;
    protected $braintreeId;
    protected $creditCard;
    protected $custom;
    protected $customer;

    public function __construct($amount, Customer\Customer $customer, CreditCard $creditCard)
    {
        $this->amount = $amount;
        $this->customer = $customer;
        $this->creditCard = $creditCard;
    }

    public function addCustomData(array $custom)
    {
        $this->custom = $custom;
    }

    public function provideBraintreeInterest()
    {
        $customer = $this->customer->provideBraintreeInterest();
        $billingAddress = $customer['address'];
        unset($customer['address']);

        return [
            'amount' => $this->amount,
            'billing' => $billingAddress,
            'customFields' => $this->custom,
            'creditCard' => $this->creditCard->provideBraintreeInterest(),
            'customer' => $customer,
        ];
    }

    public function setBraintreeId($braintreeId)
    {
        $this->braintreeId = $braintreeId;
    }
}
