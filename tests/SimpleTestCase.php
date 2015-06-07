<?php

namespace Fusani\Payment;

use PHPUnit_Framework_TestCase;
use ReflectionClass;

class SimpleTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * This function creates a function that can be called with php unit that is normally
     * protected or private.
     *
     * @param $className : the name of the class
     * @param $name : the name of the method to invoke
     * @return the method that can be invoked
     */
    protected function createTestableMethod($className, $name)
    {
        $class = new ReflectionClass($className);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}
