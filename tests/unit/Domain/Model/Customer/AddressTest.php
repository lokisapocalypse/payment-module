<?php

namespace Fusani\Payment\TestSuite;

use Fusani\Payment\Domain\Model\Customer;
use Fusani\Payment\SimpleTestCase;

/**
 * @covers Fusani\Payment\Domain\Model\Customer\Address
 */
class AddressTest extends SimpleTestCase
{
    protected $address;

    public function setup()
    {
        $this->address = new Customer\Address('123 Main Street', 'New York', 'NY', '92841', 'US');
    }

    public function testProvideBraintreeInterest()
    {
        $expected = [
            'countryCodeAlpha2' => 'US',
            'postalCode' => '92841',
            'region' => 'NY',
            'streetAddress' => '123 Main Street',
            'locality' => 'New York',
        ];

        $this->assertEquals($expected, $this->address->provideBraintreeInterest());
    }
}
