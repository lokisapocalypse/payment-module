<?php

namespace Fusani\Payment\Application;

use Fusani\Payment\Domain\Model\Customer;
use Fusani\Payment\Domain\Model\Transaction;

class PaymentService
{
    protected $transactionRepository;

    public function __construct(Transaction\TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function makePayment($amount, array $customer, array $creditCard)
    {
        $customer = new Customer\Customer(
            $customer['email'],
            $customer['firstname'],
            $customer['lastname']
        );

        $creditCard = new Transaction\CreditCard(
            $creditCard['nameOnCard'],
            $creditCard['cardNumber'],
            $creditCard['expirationMonth'],
            $creditCard['expirationYear'],
            $creditCard['securityCode']
        );

        $transaction = new Transaction\Transaction($amount, $customer, $creditCard);
        $result = $this->transactionRepository->add($transaction);

        return [
            'errors' => $result->success ? [] : $result->errors->deepAll(),
            'success' => $result->success,
        ];
    }
}
