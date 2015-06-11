<?php

namespace Fusani\Payment\TestSuite;

use Fusani\Payment\Application;
use Fusani\Payment\SimpleTestCase;

/**
 * @covers Fusani\Payment\Application\PaymentServiceFactory
 */
class PaymentServiceFactoryTest extends SimpleTestCase
{
    protected $factory;

    public function setup()
    {
        $this->factory = new Application\PaymentServiceFactory();
    }

    public function testMissingEnvironment()
    {
        $config = [];

        $this->setExpectedException('InvalidArgumentException', 'No `environment` key defined for payment-module configuration');
        $this->factory->createService($config);
    }

    public function testMissingMerchantId()
    {
        $config = [
            'payment-module' => [
                'environment' => 'sandbox',
            ],
        ];

        $this->setExpectedException('InvalidArgumentException', 'No `merchantId` key defined for payment-module configuration');
        $this->factory->createService($config);
    }

    public function testMissingPublicKey()
    {
        $config = [
            'payment-module' => [
                'environment' => 'sandbox',
                'merchantId' => 'avengers',
            ],
        ];

        $this->setExpectedException('InvalidArgumentException', 'No `publicKey` key defined for payment-module configuration');
        $this->factory->createService($config);
    }

    public function testMissingPrivateKey()
    {
        $config = [
            'payment-module' => [
                'environment' => 'sandbox',
                'merchantId' => 'avengers',
                'publicKey' => 'public',
            ],
        ];

        $this->setExpectedException('InvalidArgumentException', 'No `privateKey` key defined for payment-module configuration');
        $this->factory->createService($config);
    }

    public function testCreateService()
    {
        $config = [
            'payment-module' => [
                'environment' => 'sandbox',
                'merchantId' => 'avengers',
                'publicKey' => 'public',
                'privateKey' => 'private',
            ],
        ];

        $service = $this->factory->createService($config);
        $this->assertNotNull($service);
        $this->assertInstanceOf('Fusani\Payment\Application\PaymentService', $service);
    }
}
