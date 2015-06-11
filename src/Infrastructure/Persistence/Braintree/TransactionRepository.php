<?php

namespace Fusani\Payment\Infrastructure\Persistence\Braintree;

use Braintree_Configuration;
use Braintree_Transaction;
use Fusani\Payment\Domain\Model\Transaction;

/**
 * @codeCoverageIgnore
 */
class TransactionRepository implements Transaction\TransactionRepository
{
    public function __construct($environment, $merchantId, $publicKey, $privateKey)
    {
        Braintree_Configuration::environment($environment);
        Braintree_Configuration::merchantId($merchantId);
        Braintree_Configuration::publicKey($publicKey);
        Braintree_Configuration::privateKey($privateKey);
    }

    public function add(Transaction\Transaction $transaction)
    {
        $result = Braintree_Transaction::sale($transaction->provideBraintreeInterest());

        if ($result->success) {
            $transaction->setBraintreeId($result->transaction->id);
        }

        return $result;
    }
}
