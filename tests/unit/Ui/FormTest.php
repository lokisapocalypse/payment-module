<?php

namespace Fusani\Payment\TestSuite;

use Fusani\Payment\Ui\Form;
use Fusani\Payment\SimpleTestCase;

/**
 * @covers Fusani\Payment\Ui\Form
 */
class FormTest extends SimpleTestCase
{
    public function setup()
    {
        $this->form = new Form;
    }

    /**
     * @covers Fusani\Payment\Ui\Form::validateBetween
     */
    public function testValidateBetweenTinyint()
    {
        $method = $this->createTestableMethod('Fusani\Payment\Ui\Form', 'validateBetween');
        $validator = $method->invokeArgs($this->form, array('tinyint'));

        $this->assertEquals('Between', $validator['name']);
        $this->assertEquals(0, $validator['options']['min']);
        $this->assertEquals(255, $validator['options']['max']);

        $validator = $method->invokeArgs($this->form, array('tinyint', 50000));
        $this->assertEquals(255, $validator['options']['max']);
    }

    /**
     * @covers Fusani\Payment\Ui\Form::validateBetween
     */
    public function testValidateBetweenSmallint()
    {
        $method = $this->createTestableMethod('Fusani\Payment\Ui\Form', 'validateBetween');
        $validator = $method->invokeArgs($this->form, array('smallint'));

        $this->assertEquals('Between', $validator['name']);
        $this->assertEquals(0, $validator['options']['min']);
        $this->assertEquals(65535, $validator['options']['max']);

        $validator = $method->invokeArgs($this->form, array('smallint', 50000));
        $this->assertEquals(65535, $validator['options']['max']);
    }

    /**
     * @covers Fusani\Payment\Ui\Form::validateBetween
     */
    public function testValidateBetweenMediumint()
    {
        $method = $this->createTestableMethod('Fusani\Payment\Ui\Form', 'validateBetween');
        $validator = $method->invokeArgs($this->form, array('mediumint'));

        $this->assertEquals('Between', $validator['name']);
        $this->assertEquals(0, $validator['options']['min']);
        $this->assertEquals(16777215, $validator['options']['max']);

        $validator = $method->invokeArgs($this->form, array('mediumint', 50000));
        $this->assertEquals(16777215, $validator['options']['max']);
    }

    /**
     * @covers Fusani\Payment\Ui\Form::validateBetween
     */
    public function testValidateBetweenInt()
    {
        $method = $this->createTestableMethod('Fusani\Payment\Ui\Form', 'validateBetween');
        $validator = $method->invokeArgs($this->form, array('int'));

        $this->assertEquals('Between', $validator['name']);
        $this->assertEquals(0, $validator['options']['min']);
        $this->assertEquals(4294967295, $validator['options']['max']);

        $validator = $method->invokeArgs($this->form, array('int', 50000));
        $this->assertEquals(4294967295, $validator['options']['max']);
    }

    /**
     * @covers Fusani\Payment\Ui\Form::validateBetween
     */
    public function testValidateBetweenBigint()
    {
        $method = $this->createTestableMethod('Fusani\Payment\Ui\Form', 'validateBetween');
        $validator = $method->invokeArgs($this->form, array('bigint'));

        $this->assertEquals('Between', $validator['name']);
        $this->assertEquals(0, $validator['options']['min']);
        $this->assertEquals(18446744073709551615, $validator['options']['max']);

        $validator = $method->invokeArgs($this->form, array('bigint', 50000));
        $this->assertEquals(18446744073709551615, $validator['options']['max']);
    }

    /**
     * @covers Fusani\Payment\Ui\Form::validateBetween
     */
    public function testValidateBetweenYear()
    {
        $method = $this->createTestableMethod('Fusani\Payment\Ui\Form', 'validateBetween');
        $validator = $method->invokeArgs($this->form, array('year'));

        $this->assertEquals('Between', $validator['name']);
        $this->assertEquals(1901, $validator['options']['min']);
        $this->assertEquals(2155, $validator['options']['max']);

        $validator = $method->invokeArgs($this->form, array('year', 50000));
        $this->assertEquals(2155, $validator['options']['max']);
    }

    /**
     * @covers Fusani\Payment\Ui\Form::validateBetween
     */
    public function testValidateBetweenCustom()
    {
        $method = $this->createTestableMethod('Fusani\Payment\Ui\Form', 'validateBetween');
        $validator = $method->invokeArgs($this->form, array(15, 924));

        $this->assertEquals('Between', $validator['name']);
        $this->assertEquals(15, $validator['options']['min']);
        $this->assertEquals(924, $validator['options']['max']);
    }

    /**
     * @covers Fusani\Payment\Ui\Form::validateInArray
     */
    public function testValidateInArray()
    {
        $method = $this->createTestableMethod('Fusani\Payment\Ui\Form', 'validateInArray');
        $haystack = array('item1', 'item2');
        $validator = $method->invokeArgs($this->form, array($haystack));

        $this->assertEquals('InArray', $validator['name']);
        $this->assertEquals($haystack, $validator['options']['haystack']);
    }

    /**
     * @covers Fusani\Payment\Ui\Form::validateStringLength
     */
    public function testValidateStringLength()
    {
        $method = $this->createTestableMethod('Fusani\Payment\Ui\Form', 'validateStringLength');
        $validator = $method->invokeArgs($this->form, array(15));

        $this->assertEquals('StringLength', $validator['name']);
        $this->assertEquals(15, $validator['options']['max']);
    }
}
