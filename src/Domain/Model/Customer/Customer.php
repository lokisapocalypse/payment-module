<?php

namespace Fusani\Payment\Domain\Model\Customer;

class Customer
{
    protected $email;
    protected $firstname;
    protected $lastname;

    public function __construct($email, $firstname, $lastname)
    {
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    public function provideBraintreeInterest()
    {
        return [
            'email' => $this->email,
            'firstName' => $this->firstname,
            'lastName' => $this->lastname,
        ];
    }
}
