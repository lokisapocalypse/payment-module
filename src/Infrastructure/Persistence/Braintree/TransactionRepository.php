<?php

namespace Fusani\Payment\Infrastructure\Persistence\Braintree;

use Braintree\Configuration as BraintreeConfiguration;
use Braintree\Transaction as BraintreeTransaction;
use Fusani\Payment\Domain\Model\Transaction;

/**
 * @codeCoverageIgnore
 */
class TransactionRepository implements Transaction\TransactionRepository
{
    public function __construct($environment, $merchantId, $publicKey, $privateKey)
    {
        BraintreeConfiguration::environment($environment);
        BraintreeConfiguration::merchantId($merchantId);
        BraintreeConfiguration::publicKey($publicKey);
        BraintreeConfiguration::privateKey($privateKey);
    }

    public function add(Transaction\Transaction $transaction)
    {
        $result = BraintreeTransaction::sale($transaction->provideBraintreeInterest());

        if ($result->success) {
            $transaction->setBraintreeId($result->transaction->id);
        }

        return $result;
    }
}
