<?php

namespace Fusani\Payment\TestSuite;

use Fusani\Payment\Domain\Model\Transaction;
use Fusani\Payment\SimpleTestCase;

/**
 * @covers Fusani\Payment\Domain\Model\Transaction\CreditCard
 */
class CreditCardTest extends SimpleTestCase
{
    protected $creditCard;

    public function setup()
    {
        $this->creditCard = new Transaction\CreditCard('Peter Parker', 5, 12, 2001, 123);
    }

    public function testProvideBraintreeInterest()
    {
        $expected = [
            'cardholderName' => 'Peter Parker',
            'cvv' => 123,
            'expirationMonth' => 12,
            'expirationYear' => 2001,
            'number' => 5,
        ];

        $this->assertEquals($expected, $this->creditCard->provideBraintreeInterest());
    }
}
