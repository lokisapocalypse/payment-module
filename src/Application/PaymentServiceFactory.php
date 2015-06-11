<?php

namespace Fusani\Payment\Application;

use InvalidArgumentException;
use Fusani\Payment\Infrastructure\Persistence\Braintree;

class PaymentServiceFactory
{
    public function createService(array $config)
    {
        if (!isset($config['payment-module']['environment'])) {
            throw new InvalidArgumentException('No `environment` key defined for payment-module configuration');
        }

        if (!isset($config['payment-module']['merchantId'])) {
            throw new InvalidArgumentException('No `merchantId` key defined for payment-module configuration');
        }

        if (!isset($config['payment-module']['publicKey'])) {
            throw new InvalidArgumentException('No `publicKey` key defined for payment-module configuration');
        }

        if (!isset($config['payment-module']['privateKey'])) {
            throw new InvalidArgumentException('No `privateKey` key defined for payment-module configuration');
        }

        $transactionRepository = new Braintree\TransactionRepository(
            $config['payment-module']['environment'],
            $config['payment-module']['merchantId'],
            $config['payment-module']['publicKey'],
            $config['payment-module']['privateKey']
        );

        return new PaymentService($transactionRepository);
    }
}
