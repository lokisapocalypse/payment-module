<?php

namespace Fusani\Payment\TestSuite;

use Fusani\Payment\Application;
use Fusani\Payment\Infrastructure\Persistence\InMemory;
use Fusani\Payment\SimpleTestCase;

/**
 * @covers Fusani\Payment\Application\PaymentService
 */
class PaymentServiceTest extends SimpleTestCase
{
    protected $service;
    protected $transactionRepository;

    public function setup()
    {
        $this->transactionRepository = new InMemory\TransactionRepository();
        $this->service = new Application\PaymentService($this->transactionRepository);
    }

    public function testConstructor()
    {
        $this->assertEquals(0, $this->transactionRepository->count());
    }

    public function testMakePayment()
    {
        $customer = [
            'email' => 'peter.parker@dailybugle.com',
            'firstname' => 'Peter',
            'lastname' => 'Parker',
            'address' => [
                'streetOne' => '123 Main Street',
                'city' => 'New York',
                'stateProvince' => 'NY',
                'postalCode' => '81241',
                'country' => 'US',
            ],
        ];
        $creditCard = [
            'nameOnCard' => 'Peter Parker',
            'cardNumber' => 5,
            'expirationMonth' => 12,
            'expirationYear' => 2001,
            'securityCode' => 123,
        ];

        $result = $this->service->makePayment(100.00, $customer, $creditCard);
        $expected = [
            'errors' => [],
            'id' => $result['id'],
            'success' => true,
        ];

        $this->assertEquals($expected, $result);
        $this->assertEquals(1, $this->transactionRepository->count());
    }

    public function testMakePaymentWithCustomFields()
    {
        $customer = [
            'email' => 'peter.parker@dailybugle.com',
            'firstname' => 'Peter',
            'lastname' => 'Parker',
            'address' => [
                'streetOne' => '123 Main Street',
                'city' => 'New York',
                'stateProvince' => 'NY',
                'postalCode' => '81241',
                'country' => 'US',
            ],
        ];
        $creditCard = [
            'nameOnCard' => 'Peter Parker',
            'cardNumber' => 5,
            'expirationMonth' => 12,
            'expirationYear' => 2001,
            'securityCode' => 123,
        ];
        $custom = [
            'favoriteColor' => 'red',
        ];

        $result = $this->service->makePayment(100.00, $customer, $creditCard, $custom);
        $expected = [
            'errors' => [],
            'id' => $result['id'],
            'success' => true,
        ];

        $this->assertEquals($expected, $result);
        $this->assertEquals(1, $this->transactionRepository->count());

        $transaction = $this->transactionRepository->all();
        $transaction = $transaction[0];
        $interest = $transaction->provideBraintreeInterest();

        $this->assertEquals($custom, $interest['customFields']);
    }
}
