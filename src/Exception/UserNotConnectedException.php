<?php

namespace App\Exception;

class UserNotConnectedException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('User not connected', 403);
    }
}
