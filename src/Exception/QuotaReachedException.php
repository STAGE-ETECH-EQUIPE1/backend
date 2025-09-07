<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class QuotaReachedException extends HttpException
{
    public function __construct(string $message)
    {
        parent::__construct(Response::HTTP_TOO_MANY_REQUESTS, $message);
    }
}
