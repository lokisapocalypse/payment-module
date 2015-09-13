<?php

namespace Fusani\Payment\TestSuite;

use Fusani\Payment\Ui\Form;
use Fusani\Payment\SimpleTestCase;

/**
 * @covers Fusani\Payment\Ui\Form\CreditCardForm
 */
class CreditCardFormTest extends SimpleTestCase
{
    protected $form;

    public function setup()
    {
        $countryService = $this->getMockBuilder('Fusani\Places\Application\CountryService')
            ->disableOriginalConstructor()
            ->getMock();
        $countryService->expects($this->once())
            ->method('displayCountriesWithIsoCodes')
            ->will($this->returnValue([['isoCode' => 'LT', 'name' => 'Latveria']]));

        $this->form = new Form\CreditCardForm($countryService);
    }

    public function testIsValid()
    {
        $this->form->setData($this->validData());
        $this->assertTrue($this->form->isValid(), print_r($this->form->getMessages(), true));
    }

    public function testFirstnameFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['billingFirstName' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testFirstnameFailsWhenTooLong()
    {
        $this->form->setData(array_merge($this->validData(), ['billingFirstName' => str_repeat('x', 256)]));
        $this->assertFalse($this->form->isValid());
    }

    public function testLastnameFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['billingLastName' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testLastnameFailsWhenTooLong()
    {
        $this->form->setData(array_merge($this->validData(), ['billingLastName' => str_repeat('x', 256)]));
        $this->assertFalse($this->form->isValid());
    }

    public function testEmailFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['billingEmail' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testEmailFailsWhenTooLong()
    {
        $this->form->setData(array_merge($this->validData(), ['billingEmail' => str_repeat('x', 255).'@gmail.com']));
        $this->assertFalse($this->form->isValid());
    }

    public function testEmailFailsWhenNotAnEmail()
    {
        $this->form->setData(array_merge($this->validData(), ['billingEmail' => 'dr dooms email']));
        $this->assertFalse($this->form->isValid());
    }

    public function testStreetOneFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['billingStreetOne' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testStreetOneFailsWhenTooLong()
    {
        $this->form->setData(array_merge($this->validData(), ['billingStreetOne' => str_repeat('x', 256)]));
        $this->assertFalse($this->form->isValid());
    }

    public function testStreetTwoFailsWhenTooLong()
    {
        $this->form->setData(array_merge($this->validData(), ['billingStreetTwo' => str_repeat('x', 256)]));
        $this->assertFalse($this->form->isValid());
    }

    public function testCityFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['billingCity' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testCityFailsWhenTooLong()
    {
        $this->form->setData(array_merge($this->validData(), ['billingCity' => str_repeat('x', 256)]));
        $this->assertFalse($this->form->isValid());
    }

    public function testStateProvinceFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['billingStateProvince' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testStateProvinceFailsWhenTooLong()
    {
        $this->form->setData(array_merge($this->validData(), ['billingStateProvince' => str_repeat('x', 256)]));
        $this->assertFalse($this->form->isValid());
    }

    public function testPostalCodeFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['billingPostalCode' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testPostalCodeFailsWhenTooLong()
    {
        $this->form->setData(array_merge($this->validData(), ['billingPostalCode' => str_repeat('x', 21)]));
        $this->assertFalse($this->form->isValid());
    }

    public function testCountryFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['billingCountry' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testCountryFailsWhenNotInArray()
    {
        $this->form->setData(array_merge($this->validData(), ['billingCountry' => 'Latveria']));
        $this->assertFalse($this->form->isValid());
    }

    public function testNameOnCardFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['billingNameOnCard' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testNameOnCardFailsWhenTooLong()
    {
        $this->form->setData(array_merge($this->validData(), ['billingNameOnCard' => str_repeat('x', 256)]));
        $this->assertFalse($this->form->isValid());
    }

    public function testCardNumberFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['billingCardNumber' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testCardNumberFailsWhenTooLong()
    {
        $this->form->setData(array_merge($this->validData(), ['billingCardNumber' => str_repeat('x', 21)]));
        $this->assertFalse($this->form->isValid());
    }

    public function testExpirationMonthFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['billingExpirationMonth' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testExpirationMonthFailsWhenNotInArray()
    {
        $this->form->setData(array_merge($this->validData(), ['billingExpirationMonth' => '13']));
        $this->assertFalse($this->form->isValid());
    }

    public function testExpirationYearFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['billingExpirationYear' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testExpirationYearFailsWhenNotInArray()
    {
        $this->form->setData(array_merge($this->validData(), ['billingExpirationYear' => '1999']));
        $this->assertFalse($this->form->isValid());
    }

    public function testExpirationFilters()
    {
        $this->form->setData(array_merge($this->validData(), ['billingExpiration' => ' 1999 ']));
        $this->assertTrue($this->form->isValid());
        $data = $this->form->getData();
        $this->assertEquals('1999', $data['billingExpiration']);
    }

    public function testSecurityCodeFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['billingSecurityCode' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testSecurityCodeFailsWhenNotInArray()
    {
        $this->form->setData(array_merge($this->validData(), ['billingSecurityCode' => str_repeat('x', 11)]));
        $this->assertFalse($this->form->isValid());
    }

    protected function validData()
    {
        return [
            'billingFirstName' => 'Victor',
            'billingLastName' => 'Von Doom',
            'billingEmail' => 'drdoom@latveria.gov',
            'billingStreetOne' => '123 Dr. Doom Avenue',
            'billingCity' => 'Doom City',
            'billingStateProvince' => 'Doom Carolina',
            'billingPostalCode' => 'Doom23',
            'billingCountry' => 'LT',
            'billingNameOnCard' => 'Victor Von Doom',
            'billingCardNumber' => '4111111111111111',
            'billingExpirationMonth' => '12',
            'billingExpirationYear' => date('Y') + 1,
            'billingSecurityCode' => '123',
        ];
    }
}
