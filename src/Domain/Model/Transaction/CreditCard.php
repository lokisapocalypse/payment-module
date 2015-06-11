<?php

namespace Fusani\Payment\Domain\Model\Transaction;

class CreditCard
{
    protected $cvv;
    protected $expirationMonth;
    protected $expirationYear;
    protected $name;
    protected $number;

    public function __construct($name, $number, $expirationMonth, $expirationYear, $cvv)
    {
        $this->cvv = $cvv;
        $this->expirationMonth = $expirationMonth;
        $this->expirationYear = $expirationYear;
        $this->name = $name;
        $this->number = $number;
    }

    public function provideBraintreeInterest()
    {
        return [
            'cardholderName' => $this->name,
            'cvv' => $this->cvv,
            'expirationMonth' => $this->expirationMonth,
            'expirationYear' => $this->expirationYear,
            'number' => $this->number,
        ];
    }
}
