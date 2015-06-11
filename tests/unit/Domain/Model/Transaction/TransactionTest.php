<?php

namespace Fusani\Payment\TestSuite;

use Fusani\Payment\Domain\Model\Customer;
use Fusani\Payment\Domain\Model\Transaction;
use Fusani\Payment\SimpleTestCase;
use PHPUnit_Framework_Assert;

/**
 * @covers Fusani\Payment\Domain\Model\Transaction\Transaction
 */
class TransactionTest extends SimpleTestCase
{
    protected $creditCard;
    protected $customer;
    protected $transaction;

    public function setup()
    {
        $this->customer = new Customer\Customer('peter.parker@dailybugle.com', 'Peter', 'Parker');
        $this->creditCard = new Transaction\CreditCard('Peter Parker', 5, 12, 2001, 123);
        $this->transaction = new Transaction\Transaction(100.00, $this->customer, $this->creditCard);
    }

    public function testProvideBraintreeInterest()
    {
        $expected = [
            'amount' => 100.00,
            'creditCard' => $this->creditCard->provideBraintreeInterest(),
            'customer' => $this->customer->provideBraintreeInterest(),
        ];

        $this->assertEquals($expected, $this->transaction->provideBraintreeInterest());
    }

    public function testSetBraintreeId()
    {
        $this->transaction->setBraintreeId('braaaaaaaaains');
        $this->assertEquals('braaaaaaaaains', PHPUnit_Framework_Assert::readAttribute($this->transaction, 'braintreeId'));
    }
}
