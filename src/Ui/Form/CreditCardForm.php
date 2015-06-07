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
        asort($countries);

        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('id', 'credit-card-form');

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'maxlength' => '100',
                'placeholder' => 'First Name',
                'required' => 'required',
            ],
            'name' => 'firstname',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'maxlength' => '100',
                'placeholder' => 'Last Name',
                'required' => 'required',
            ],
            'name' => 'lastname',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'maxlength' => '255',
                'placeholder' => 'Email',
                'required' => 'required',
                'type' => 'email',
            ],
            'name' => 'email',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'maxlength' => '255',
                'placeholder' => 'Street',
                'required' => 'required',
            ],
            'name' => 'streetOne',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'maxlength' => '255',
                'placeholder' => 'Street',
            ],
            'name' => 'streetTwo',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'maxlength' => '255',
                'placeholder' => 'City',
                'required' => 'required',
            ],
            'name' => 'city',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'maxLength' => '255',
                'placeholder' => 'State / Province',
                'required' => 'required',
            ],
            'name' => 'stateProvince',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'maxlength' => '20',
                'placeholder' => 'Postal code',
                'required' => 'required',
            ],
            'name' => 'postalCode',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Country',
                'required' => 'required',
            ],
            'name' => 'country',
            'options' => [
                'value_options' => $countries,
            ],
            'type' => 'Zend\Form\Element\Select',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'maxlength' => '255',
                'placeholder' => 'Name on card',
                'required' => 'required',
            ],
            'name' => 'nameOnCard',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'maxlength' => '20',
                'placeholder' => 'Card number',
                'required' => 'required',
            ],
            'name' => 'cardNumber',
        ]);

        $months = array_combine(range(1, 12), range(1, 12));
        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Expiration month',
                'required' => 'required',
            ],
            'name' => 'expirationMonth',
            'options' => [
                'value_options' => $months,
            ],
            'type' => 'Zend\Form\Element\Select',
        ]);

        $thisYear = date('Y');
        $years = array_combine(range($thisYear, $thisYear + 25), range($thisYear, $thisYear + 25));
        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Expiration year',
                'required' => 'required',
            ],
            'name' => 'expirationYear',
            'options' => [
                'value_options' => $years,
            ],
            'type' => 'Zend\Form\Element\Select',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'form-control',
                'maxlength' => '10',
                'placeholder' => 'Security code',
                'required' => 'required',
            ],
            'name' => 'securityCode',
        ]);

        $this->add([
            'attributes' => [
                'class' => 'btn btn-default btn-primary submit',
                'data-loading-text' => 'Submitting...',
                'value' => 'Submit',
            ],
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
        ]);

        // now set up filters and validators
        // firstname
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'firstname',
            'required' => true,
            'validators' => [$this->validateStringLength(100), $this->validateNotEmpty],
        ]);

        // lastname
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'lastname',
            'required' => true,
            'validators' => [$this->validateStringLength(100), $this->validateNotEmpty],
        ]);

        // email address
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'email',
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
            'name' => 'streetOne',
            'required' => true,
            'validators' => [$this->validateStringLength(255), $this->validateNotEmpty],
        ]);

        // street
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'streetTwo',
            'required' => false,
            'validators' => [$this->validateStringLength(255)],
        ]);

        // city
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'city',
            'required' => true,
            'validators' => [$this->validateStringLength(255), $this->validateNotEmpty],
        ]);

        // state
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'stateProvince',
            'required' => true,
            'validators' => [$this->validateStringLength(255), $this->validateNotEmpty],
        ]);

        // zip
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'postalCode',
            'required' => true,
            'validators' => [$this->validateStringLength(20), $this->validateNotEmpty],
        ]);

        // country
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'country',
            'required' => true,
            'validators' => [$this->validateNotEmpty, $this->validateInArray(array_keys($countries))],
        ]);

        // name on card
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'nameOnCard',
            'required' => true,
            'validators' => [$this->validateStringLength(255), $this->validateNotEmpty],
        ]);

        // card number
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'cardNumber',
            'required' => true,
            'validators' => [$this->validateStringLength(20), $this->validateNotEmpty],
        ]);

        // expiration month
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'expirationMonth',
            'required' => true,
            'validators' => [$this->validateNotEmpty, $this->validateInArray(array_keys($months))],
        ]);

        // expiration year
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'expirationYear',
            'required' => true,
            'validators' => [$this->validateNotEmpty, $this->validateInArray(array_keys($years))],
        ]);

        // security code
        $this->fusaniInputFilter->add([
            'filters' => [$this->filterStringTrim],
            'name' => 'securityCode',
            'required' => true,
            'validators' => [$this->validateStringLength(10), $this->validateNotEmpty],
        ]);

        // attach validators and filters
        $this->setInputFilter($this->fusaniInputFilter);

        // prepare the form
        $this->prepare();
    }
}
