<?php

namespace Fusani\Payment\Domain\Model\Transaction;

interface TransactionRepository
{
    public function add(Transaction $transaction);
}
