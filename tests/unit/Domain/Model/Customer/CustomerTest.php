<?php

namespace Fusani\Payment\TestSuite;

use Fusani\Payment\Domain\Model\Customer;
use Fusani\Payment\SimpleTestCase;

/**
 * @covers Fusani\Payment\Domain\Model\Customer\Customer
 */
class CustomerTest extends SimpleTestCase
{
    protected $customer;

    public function setup()
    {
        $this->customer = new Customer\Customer('peter.parker@dailybugle.com', 'Peter', 'Parker');
    }

    public function testProvideBraintreeInterest()
    {
        $expected = [
            'email' => 'peter.parker@dailybugle.com',
            'firstName' => 'Peter',
            'lastName' => 'Parker',
        ];

        $this->assertEquals($expected, $this->customer->provideBraintreeInterest());
    }
}
