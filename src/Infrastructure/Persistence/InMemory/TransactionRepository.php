<?php

namespace Fusani\Payment\Infrastructure\Persistence\InMemory;

use Fusani\Payment\Domain\Model\Transaction;

class TransactionRepository implements Transaction\TransactionRepository
{
    protected $transactions;

    public function __construct()
    {
        $this->transactions = [];
    }

    public function add(Transaction\Transaction $transaction)
    {
        $this->transactions[] = $transaction;

        $object = new \stdClass();
        $object->success = true;

        return $object;
    }

    public function count()
    {
        return count($this->transactions);
    }
}
