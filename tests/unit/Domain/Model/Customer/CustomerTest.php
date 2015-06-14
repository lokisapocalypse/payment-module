<?php

namespace Fusani\Payment\TestSuite;

use Fusani\Payment\Domain\Model\Customer;
use Fusani\Payment\SimpleTestCase;

/**
 * @covers Fusani\Payment\Domain\Model\Customer\Customer
 */
class CustomerTest extends SimpleTestCase
{
    protected $address;
    protected $customer;

    public function setup()
    {
        $this->address = new Customer\Address('123 Main Street', 'New York', 'NY', '92841', 'US');
        $this->customer = new Customer\Customer('peter.parker@dailybugle.com', 'Peter', 'Parker', $this->address);
    }

    public function testProvideBraintreeInterest()
    {
        $expected = [
            'address' => $this->address->provideBraintreeInterest(),
            'email' => 'peter.parker@dailybugle.com',
            'firstName' => 'Peter',
            'lastName' => 'Parker',
        ];

        $this->assertEquals($expected, $this->customer->provideBraintreeInterest());
    }
}
