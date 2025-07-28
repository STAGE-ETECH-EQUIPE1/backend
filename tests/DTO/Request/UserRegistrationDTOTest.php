<?php

namespace App\Tests\DTO\Request;

use App\DTO\Request\UserRegistrationDTO;
use App\Tests\DTO\ValidationTestTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRegistrationDTOTest extends KernelTestCase
{
    use ValidationTestTrait;

    public function getDTO(): UserRegistrationDTO
    {
        return (new UserRegistrationDTO())
            ->setEmail('admin@domain.com')
            ->setPassword('Admin@123')
            ->setConfirmPassword('Admin@123')
            ->setPhone('0312345678')
            ->setFullName('Admin User')
            ->setUsername('admin.user')
        ;
    }

    public function testValidDTO(): void
    {
        $this->assertHasErrors($this->getDTO());
    }

    public function testInvalidEmail(): void
    {
        $this->assertHasErrors(
            $this->getDTO()->setEmail('invalid-email'),
            1
        );
    }

    public function testBlankProperty(): void
    {
        $this->assertHasErrors(
            $this->getDTO()->setEmail(''),
            1
        );
    }

    public function testInvalidConfirmPassword(): void
    {
        $this->assertHasErrors(
            $this->getDTO()->setConfirmPassword('otherPassword'),
            1
        );
    }
}
