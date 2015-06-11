<?php

namespace Fusani\Payment\TestSuite;

use Fusani\Payment\Ui\Form;
use Fusani\Payment\SimpleTestCase;

/**
 * @covers Fusani\Payment\Ui\Form\CreditCardFormFactory
 */
class CreditCardFormFactoryTest extends SimpleTestCase
{
    protected $factory;

    public function setup()
    {
        $this->factory = new Form\CreditCardFormFactory();
    }

    public function testCreateForm()
    {
        $form = $this->factory->createForm();
        $this->assertNotNull($form);
        $this->assertInstanceOf('Fusani\Payment\Ui\Form\CreditCardForm', $form);
    }
}
