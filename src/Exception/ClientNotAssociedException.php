<?php

namespace App\Exception;

class ClientNotAssociedException extends \RuntimeException
{
    public function __construct(string $message = 'Client is not associated with the user.')
    {
        parent::__construct($message);
    }
}
