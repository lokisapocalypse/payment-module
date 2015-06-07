<?php

namespace Fusani\Payment\Ui;

class Form extends \Zend\Form\Form
{
    // input filter to set up filters and validators
    protected $fusaniInputFilter;

    // default filters
    protected $filterStringTrim;

    // default validators
    protected $validateEmailAddress;
    protected $validateNotEmpty;

    public function __construct()
    {
        // create the zend form
        parent::__construct();

        // make it a bootstrap form
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('role', 'form');

        // set the default objects we'll use to build the form validator
        $this->fusaniInputFilter = new \Zend\InputFilter\InputFilter();

        // create some default input filters
        $this->filterStringTrim = array('name' => 'StringTrim');

        // create some default validators will we reuse
        $this->validateEmailAddress = array('name' => 'EmailAddress');
        $this->validateNotEmpty = array('name' => 'NotEmpty');
    }

    /**
     * This function builds an in between validator. This is done in a function so that
     * everything looks pretty. Min can be a string mapping to a mysql range of values (unsigned assumed)
     *
     * @param $min : the minimum value
     * @param $max : the maximum value
     * @return an array defining the validator
     */
    protected function validateBetween($min, $max = '')
    {
        // switch on min for mysql types
        switch (strtolower($min)) {
            case 'tinyint':
                $min = 0;
                $max = 255;
                break;

            case 'smallint':
                $min = 0;
                $max = 65535;
                break;

            case 'mediumint':
                $min = 0;
                $max = 16777215;
                break;

            case 'int':
                $min = 0;
                $max = 4294967295;
                break;

            case 'bigint':
                $min = 0;
                $max = 18446744073709551615;
                break;

            case 'year':
                $min = 1901;
                $max = 2155;
                break;

            default:
                // leave min and max alone
                break;
        }

        return array('name' => 'Between', 'options' => array('min' => $min, 'max' => $max));
    }

    /**
     * This function builds an in array validator. This is done in a function to
     * make the constructor cleaner.
     *
     * @param $haystack : the items in the haystack
     * @return an array defining the validator
     */
    protected function validateInArray(array $haystack)
    {
        return array('name' => 'InArray', 'options' => array('haystack' => $haystack));
    }

    /**
     * This function constructs a string length validator. It accepts the
     * maximum length as an argument.
     *
     * @param $length : the allowed length of the element
     * @return a string length validator
     */
    protected function validateStringLength($length)
    {
        return array('name' => 'StringLength', 'options' => array('max' => $length));
    }
}
