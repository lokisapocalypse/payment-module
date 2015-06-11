<?php

namespace Fusani\Payment\TestSuite;

use Fusani\Payment\Infrastructure\Persistence\InMemory;
use Fusani\Payment\SimpleTestCase;

/**
 * @covers Fusani\Payment\Infrastructure\Persistence\InMemory\TransactionRepository
 */
class TransactionRepositoryTest extends SimpleTestCase
{
    protected $repository;

    public function setup()
    {
        $this->repository = new InMemory\TransactionRepository();
    }

    public function testConstructor()
    {
        $this->assertEquals(0, $this->repository->count());
    }

    public function testAdd()
    {
        $transaction = $this->getMockBuilder('Fusani\Payment\Domain\Model\Transaction\Transaction')
            ->disableOriginalConstructor()
            ->getMock();

        $this->repository->add($transaction);

        $this->assertEquals(1, $this->repository->count());
    }
}
