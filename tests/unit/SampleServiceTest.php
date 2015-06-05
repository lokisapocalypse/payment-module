<?php

namespace Fusani\Payment;

use Fusani\Payment\Application\SampleService;
use Fusani\Payment\SimpleTestCase;

/**
 * @covers Fusani\Payment\Application\SampleService
 */
class SampleServiceTest extends SimpleTestCase
{
    public function testSomething()
    {
        $service = new SampleService();
        $this->assertTrue($service->doSomething());
    }
}
