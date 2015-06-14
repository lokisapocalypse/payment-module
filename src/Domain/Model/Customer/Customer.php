<?php

namespace Fusani\Payment\Domain\Model\Customer;

class Customer
{
    protected $address;
    protected $email;
    protected $firstname;
    protected $lastname;

    public function __construct($email, $firstname, $lastname, Address $address)
    {
        $this->address = $address;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    public function provideBraintreeInterest()
    {
        return [
            'address' => $this->address->provideBraintreeInterest(),
            'email' => $this->email,
            'firstName' => $this->firstname,
            'lastName' => $this->lastname,
        ];
    }
}
