<?php

namespace Engine;

use Progsmile\Validator\Helpers\ValidatorFacade;
use Progsmile\Validator\Validator as BaseValidator;

class Validator
{
    private array $messages = [];
    private array $rules = [];
    private array $data = [];
    private ValidatorFacade $validator;

    public function __construct(array $rules, array $data)
    {
        $this->rules = $rules;
        $this->data = $data;

        $this->validator = BaseValidator::make($this->data, $this->rules);
        $this->validate();
    }

    public function isFail()
    {
        return $this->validator->fails();
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function getMessage($field = null)
    {
        return $this->messages[$field] ?? null;
    }

    private function validate()
    {
        if ($this->validator->fails()) {
            foreach ($this->data as $key => $value) {
                if ($this->validator->messages($key)) {
                    $this->messages[$key] = $this->validator->first($key);
                }
            }

            Session::set('errors', $this->messages);
        } else {
            Session::delete('errors');
        }

        return $this;
    }
}
