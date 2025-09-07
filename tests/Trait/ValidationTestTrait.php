<?php

namespace App\Tests\Trait;

use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

trait ValidationTestTrait
{
    public function assertHasErrors(object $code, int $errorNumber = 0): void
    {
        self::bootKernel();
        /** @var ValidatorInterface $validator */
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $errors = $validator->validate($code);

        $messages = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath().' => '.$error->getMessage();
        }
        $this->assertCount($errorNumber, $errors, implode(', ', $messages));
    }
}
