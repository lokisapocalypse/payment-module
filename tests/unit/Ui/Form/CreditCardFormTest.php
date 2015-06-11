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
        $this->form->setData(array_merge($this->validData(), ['firstname' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testFirstnameFailsWhenTooLong()
    {
        $this->form->setData(array_merge($this->validData(), ['firstname' => str_repeat('x', 256)]));
        $this->assertFalse($this->form->isValid());
    }

    public function testLastnameFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['lastname' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testLastnameFailsWhenTooLong()
    {
        $this->form->setData(array_merge($this->validData(), ['lastname' => str_repeat('x', 256)]));
        $this->assertFalse($this->form->isValid());
    }

    public function testEmailFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['email' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testEmailFailsWhenTooLong()
    {
        $this->form->setData(array_merge($this->validData(), ['email' => str_repeat('x', 255).'@gmail.com']));
        $this->assertFalse($this->form->isValid());
    }

    public function testEmailFailsWhenNotAnEmail()
    {
        $this->form->setData(array_merge($this->validData(), ['email' => 'dr dooms email']));
        $this->assertFalse($this->form->isValid());
    }

    public function testStreetOneFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['streetOne' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testStreetOneFailsWhenTooLong()
    {
        $this->form->setData(array_merge($this->validData(), ['streetOne' => str_repeat('x', 256)]));
        $this->assertFalse($this->form->isValid());
    }

    public function testStreetTwoFailsWhenTooLong()
    {
        $this->form->setData(array_merge($this->validData(), ['streetTwo' => str_repeat('x', 256)]));
        $this->assertFalse($this->form->isValid());
    }

    public function testCityFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['city' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testCityFailsWhenTooLong()
    {
        $this->form->setData(array_merge($this->validData(), ['city' => str_repeat('x', 256)]));
        $this->assertFalse($this->form->isValid());
    }

    public function testStateProvinceFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['stateProvince' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testStateProvinceFailsWhenTooLong()
    {
        $this->form->setData(array_merge($this->validData(), ['stateProvince' => str_repeat('x', 256)]));
        $this->assertFalse($this->form->isValid());
    }

    public function testPostalCodeFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['postalCode' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testPostalCodeFailsWhenTooLong()
    {
        $this->form->setData(array_merge($this->validData(), ['postalCode' => str_repeat('x', 21)]));
        $this->assertFalse($this->form->isValid());
    }

    public function testCountryFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['country' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testCountryFailsWhenNotInArray()
    {
        $this->form->setData(array_merge($this->validData(), ['country' => 'Latveria']));
        $this->assertFalse($this->form->isValid());
    }

    public function testNameOnCardFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['nameOnCard' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testNameOnCardFailsWhenTooLong()
    {
        $this->form->setData(array_merge($this->validData(), ['nameOnCard' => str_repeat('x', 256)]));
        $this->assertFalse($this->form->isValid());
    }

    public function testCardNumberFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['cardNumber' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testCardNumberFailsWhenTooLong()
    {
        $this->form->setData(array_merge($this->validData(), ['cardNumber' => str_repeat('x', 21)]));
        $this->assertFalse($this->form->isValid());
    }

    public function testExpirationMonthFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['expirationMonth' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testExpirationMonthFailsWhenNotInArray()
    {
        $this->form->setData(array_merge($this->validData(), ['expirationMonth' => '13']));
        $this->assertFalse($this->form->isValid());
    }

    public function testExpirationYearFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['expirationYear' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testExpirationYearFailsWhenNotInArray()
    {
        $this->form->setData(array_merge($this->validData(), ['expirationYear' => '1999']));
        $this->assertFalse($this->form->isValid());
    }

    public function testSecurityCodeFailsWhenMissing()
    {
        $this->form->setData(array_merge($this->validData(), ['securityCode' => null]));
        $this->assertFalse($this->form->isValid());
    }

    public function testSecurityCodeFailsWhenNotInArray()
    {
        $this->form->setData(array_merge($this->validData(), ['securityCode' => str_repeat('x', 11)]));
        $this->assertFalse($this->form->isValid());
    }

    protected function validData()
    {
        return [
            'firstname' => 'Victor',
            'lastname' => 'Von Doom',
            'email' => 'drdoom@latveria.gov',
            'streetOne' => '123 Dr. Doom Avenue',
            'city' => 'Doom City',
            'stateProvince' => 'Doom Carolina',
            'postalCode' => 'Doom23',
            'country' => 'LT',
            'nameOnCard' => 'Victor Von Doom',
            'cardNumber' => '4111111111111111',
            'expirationMonth' => '12',
            'expirationYear' => date('Y') + 1,
            'securityCode' => '123',
        ];
    }
}
