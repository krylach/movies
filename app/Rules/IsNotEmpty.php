<?php

namespace App\Rules;

use Progsmile\Validator\Rules\BaseRule;

class IsNotEmpty extends BaseRule
{
    public function isValid()
    {
        $params = $this->getParams();

        return strlen($params[1]) !== 0;
    }

    public function getMessage()
    {
        return 'Field :field: must not be empty';
    }
}
