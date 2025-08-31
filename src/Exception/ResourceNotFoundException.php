<?php

namespace App\Exception;

class ResourceNotFoundException extends \RuntimeException
{
    public function __construct(string $message = 'Resource not found')
    {
        parent::__construct($message);
    }
}
