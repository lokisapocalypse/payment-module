<?php

namespace Fusani\Payment\Ui\Form;

use Fusani\Payment\Ui\Form;
use Fusani\Places\Application;

class CreditCardForm extends Form
{
    public function __construct(Application\CountryService $countryService)
    {
        // create the zend form
        parent::__construct();

        $countries = [];
        foreach ($countryService->displayCountriesWithIsoCodes() as $country) {
            $countries[$country['isoCode']] = $country['name'];
        }
        $countries = ['' => ''] + $countries;
        asort($countries);

        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('id', 'credit-card-form');

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'maxlength' => '255',
                'placeholder' => 'First Name',
                'required' => 'required',
            ],
            'name' => 'billingFirstName',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'maxlength' => '255',
                'placeholder' => 'Last Name',
                'required' => 'required',
            ],
            'name' => 'billingLastName',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'maxlength' => '255',
                'placeholder' => 'Email',
                'required' => 'required',
                'type' => 'email',
            ],
            'name' => 'billingEmail',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'maxlength' => '255',
                'placeholder' => 'Street',
                'required' => 'required',
            ],
            'name' => 'billingStreetOne',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'maxlength' => '255',
                'placeholder' => 'Street',
            ],
            'name' => 'billingStreetTwo',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'maxlength' => '255',
                'placeholder' => 'City',
                'required' => 'required',
            ],
            'name' => 'billingCity',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'maxLength' => '255',
                'placeholder' => 'State / Province',
                'required' => 'required',
            ],
            'name' => 'billingStateProvince',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'maxlength' => '20',
                'placeholder' => 'Postal code',
                'required' => 'required',
            ],
            'name' => 'billingPostalCode',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Country',
                'required' => 'required',
            ],
            'name' => 'billingCountry',
            'options' => [
                'value_options' => $countries,
            ],
            'type' => 'Zend\Form\Element\Select',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'maxlength' => '175',
                'placeholder' => 'Name on card',
                'required' => 'required',
            ],
            'name' => 'billingNameOnCard',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'maxlength' => '20',
                'placeholder' => 'Card number',
                'required' => 'required',
            ],
            'name' => 'billingCardNumber',
        ]);

        $months = ['' => ''] + array_combine(range(1, 12), range(1, 12));
        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Expiration month',
                'required' => 'required',
            ],
            'name' => 'billingExpirationMonth',
            'options' => [
                'value_options' => $months,
            ],
            'type' => 'Zend\Form\Element\Select',
        ]);

        $thisYear = date('Y');
        $years = ['' => ''] + array_combine(range($thisYear, $thisYear + 25), range($thisYear, $thisYear + 25));
        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Expiration year',
                'required' => 'required',
            ],
            'name' => 'billingExpirationYear',
            'options' => [
                'value_options' => $years,
            ],
            'type' => 'Zend\Form\Element\Select',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'MM / YY',
                'required' => 'required',
                'type' => 'tel',
            ],
            'name' => 'billingExpiration',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'maxlength' => '10',
                'placeholder' => 'Security code',
                'required' => 'required',
            ],
            'name' => 'billingSecurityCode',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'btn btn-default btn-primary submit',
                'data-loading-text' => 'Submitting...',
                'value' => 'Submit',
            ],
            'name' => 'billingSubmit',
            'type' => 'Zend\Form\Element\Submit',
        ]);

        // now set up filters and validators
        // firstname
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'billingFirstName',
            'required' => true,
            'validators' => [$this->validateStringLength(255), $this->validateNotEmpty],
        ]);

        // lastname
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'billingLastName',
            'required' => true,
            'validators' => [$this->validateStringLength(255), $this->validateNotEmpty],
        ]);

        // email address
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'billingEmail',
            'required' => true,
            'validators' => [
                $this->validateStringLength(255),
                $this->validateNotEmpty,
                $this->validateEmailAddress,
            ],
        ]);

        // street
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'billingStreetOne',
            'required' => true,
            'validators' => [$this->validateStringLength(255), $this->validateNotEmpty],
        ]);

        // street
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'billingStreetTwo',
            'required' => false,
            'validators' => [$this->validateStringLength(255)],
        ]);

        // city
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'billingCity',
            'required' => true,
            'validators' => [$this->validateStringLength(255), $this->validateNotEmpty],
        ]);

        // state
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'billingStateProvince',
            'required' => true,
            'validators' => [$this->validateStringLength(255), $this->validateNotEmpty],
        ]);

        // zip
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'billingPostalCode',
            'required' => true,
            'validators' => [$this->validateStringLength(20), $this->validateNotEmpty],
        ]);

        // country
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'billingCountry',
            'required' => true,
            'validators' => [$this->validateNotEmpty, $this->validateInArray(array_keys($countries))],
        ]);

        // name on card
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'billingNameOnCard',
            'required' => true,
            'validators' => [$this->validateStringLength(175), $this->validateNotEmpty],
        ]);

        // card number
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'billingCardNumber',
            'required' => true,
            'validators' => [$this->validateStringLength(20), $this->validateNotEmpty],
        ]);

        // expiration month
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'billingExpirationMonth',
            'required' => true,
            'validators' => [$this->validateNotEmpty, $this->validateInArray(array_keys($months))],
        ]);

        // expiration year
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'billingExpirationYear',
            'required' => true,
            'validators' => [$this->validateNotEmpty, $this->validateInArray(array_keys($years))],
        ]);

        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'billingExpiration',
            'required' => false,
            'validators' => [],
        ]);

        // security code
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'billingSecurityCode',
            'required' => true,
            'validators' => [$this->validateStringLength(10), $this->validateNotEmpty],
        ]);

        // attach validators and filters
        $this->setInputFilter($this->fusaniInputFilter);

        // prepare the form
        $this->prepare();
    }
}
