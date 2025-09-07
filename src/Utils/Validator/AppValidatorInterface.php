<?php

namespace App\Utils\Validator;

interface AppValidatorInterface
{
    /**
     * Validate Request from user input.
     *
     * @return string[]
     */
    public function validateRequest(object $request): array;
}
