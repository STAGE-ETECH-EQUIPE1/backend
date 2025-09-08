<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class GeminiApiException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct(Response::HTTP_TOO_MANY_REQUESTS, $message);
    }
}
