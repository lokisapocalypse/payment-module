<?php

namespace Fusani\Payment\Ui\Form;

use Fusani\Places\Application;

class CreditCardFormFactory
{
    public function createForm()
    {
        $factory = new Application\CountryServiceFactory();
        return new CreditCardForm($factory->createService());
    }
}
