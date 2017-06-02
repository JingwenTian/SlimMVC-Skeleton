<?php

namespace App\helper\Authentication;

class Token
{
    public $decoded;

    public function hydrate($decoded)
    {
        $this->decoded = $decoded;
    }

    public function getScope()
    {
        return (array) $this->decoded->scope;
    }
}
