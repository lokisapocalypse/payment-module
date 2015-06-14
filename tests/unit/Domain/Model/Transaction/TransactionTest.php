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
    protected $address;
    protected $creditCard;
    protected $customer;
    protected $transaction;

    public function setup()
    {
        $this->address = new Customer\Address('123 Main Street', 'New York', 'NY', '28347', 'US');
        $this->customer = new Customer\Customer('peter.parker@dailybugle.com', 'Peter', 'Parker', $this->address);
        $this->creditCard = new Transaction\CreditCard('Peter Parker', 5, 12, 2001, 123);
        $this->transaction = new Transaction\Transaction(100.00, $this->customer, $this->creditCard);
    }

    public function testAddCustomData()
    {
        $custom = ['wife' => 'Mary Jane Watson'];
        $this->transaction->addCustomData($custom);
        $interest = $this->transaction->provideBraintreeInterest();

        $this->assertEquals($custom, $interest['customFields']);
    }

    public function testProvideBraintreeInterest()
    {
        $expected = [
            'amount' => 100.00,
            'billing' => $this->customer->provideBraintreeInterest()['address'],
            'creditCard' => $this->creditCard->provideBraintreeInterest(),
            'customer' => $this->customer->provideBraintreeInterest(),
            'customFields' => null,
        ];
        unset($expected['customer']['address']);

        $this->assertEquals($expected, $this->transaction->provideBraintreeInterest());
    }

    public function testSetBraintreeId()
    {
        $this->transaction->setBraintreeId('braaaaaaaaains');
        $this->assertEquals('braaaaaaaaains', PHPUnit_Framework_Assert::readAttribute($this->transaction, 'braintreeId'));
    }
}
