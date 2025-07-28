<?php

namespace App\Tests\DTO\Request;

use App\DTO\Request\UpdatePasswordDTO;
use App\Tests\DTO\ValidationTestTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UpdatePasswordDTOTest extends KernelTestCase
{
    use ValidationTestTrait;

    public function getDTO(): UpdatePasswordDTO
    {
        return (new UpdatePasswordDTO())
            ->setCurrentPassword('currentPassword')
            ->setNewPassword('newPassword')
            ->setConfirmPassword('newPassword')
        ;
    }

    public function testValidDTO(): void
    {
        $this->assertHasErrors($this->getDTO());
    }

    public function testInvalidConfirmPassword(): void
    {
        $this->assertHasErrors(
            $this->getDTO()->setConfirmPassword('invalid-Password'),
            1
        );
    }
}
