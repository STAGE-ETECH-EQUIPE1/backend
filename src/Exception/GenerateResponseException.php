<?php

namespace App\Exception;

class GenerateResponseException extends \RuntimeException
{
    public function __construct(string $message = 'Error generating Response from AI')
    {
        parent::__construct($message);
    }
}
