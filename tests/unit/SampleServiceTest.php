<?php

namespace Fusani\Fusani;

use Fusani\Fusani\Application\SampleService;
use Fusani\Fusani\SimpleTestCase;

/**
 * @covers Fusani\Fusani\Application\SampleService
 */
class SampleServiceTest extends SimpleTestCase
{
    public function testSomething()
    {
        $service = new SampleService();
        $this->assertTrue($service->doSomething());
    }
}
