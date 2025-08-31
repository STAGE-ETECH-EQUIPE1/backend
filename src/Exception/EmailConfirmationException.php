<?php

namespace App\Exception;

class EmailConfirmationException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Invalid Signature for verification email');
    }
}
