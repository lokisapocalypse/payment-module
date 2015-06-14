<?php

namespace Fusani\Payment\Domain\Model\Customer;

class Address
{
    protected $city;
    protected $country;
    protected $postalCode;
    protected $stateProvince;
    protected $streetOne;

    public function __construct($streetOne, $city, $stateProvince, $postalCode, $country)
    {
        $this->city = $city;
        $this->country = $country;
        $this->postalCode = $postalCode;
        $this->stateProvince = $stateProvince;
        $this->streetOne = $streetOne;
    }

    public function provideBraintreeInterest()
    {
        return [
            'countryCodeAlpha2' => $this->country,
            'postalCode' => $this->postalCode,
            'region' => $this->stateProvince,
            'streetAddress' => $this->streetOne,
            'locality' => $this->city,
        ];
    }
}
