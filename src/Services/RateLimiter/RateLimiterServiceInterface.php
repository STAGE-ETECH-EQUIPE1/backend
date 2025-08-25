<?php

namespace App\Services\RateLimiter;

interface RateLimiterServiceInterface 
{
    public function tokenCount(): void;
}