<?php

namespace App\Services;

class TokenService
{
    private $tokenLength = 32;

    public function generateToken() : string
    {
        /**
         * some logic for generate token
         */

        return \Illuminate\Support\Str::random($this->tokenLength);
    }

}
