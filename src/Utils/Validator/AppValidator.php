<?php

namespace App\Utils\Validator;

use Symfony\Component\Validator\Validator\ValidatorInterface;

final class AppValidator implements AppValidatorInterface
{
    public function __construct(
        private readonly ValidatorInterface $validator,
    ) {
    }

    public function validateRequest(object $request): array
    {
        $errors = $this->validator->validate($request);

        $errorMessages = [];
        foreach ($errors as $error) {
            $errorMessages[$error->getPropertyPath()] = $error->getMessage();
        }

        return $errorMessages;
    }
}
