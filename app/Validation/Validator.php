<?php

namespace Cart\Validation;

use Cart\Validation\Contracts\ValidatorInterface;

use Psr\Http\Message\ServerRequestInterface as Request;

class Validator implements ValidatorInterface
{
    public function validate(Request $request, array $rules)
    {
        // TODO
        return $this;
    }

    public function fails()
    {
        // TODO

        return true;
    }
}