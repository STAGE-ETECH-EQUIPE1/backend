<?php

namespace App\Tests\DTO\Request;

use App\DTO\Request\ResetPasswordDTO;
use App\Tests\DTO\ValidationTestTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ResetPasswordDTOTest extends KernelTestCase
{
    use ValidationTestTrait;

    public function getDTO(): ResetPasswordDTO
    {
        return (new ResetPasswordDTO())
            ->setEmail('admin@domain.com')
        ;
    }

    public function testValidDTO(): void
    {
        $this->assertHasErrors($this->getDTO());
    }

    public function testInvalidEmail(): void
    {
        $this->assertHasErrors($this->getDTO()->setEmail('invalid-email'), 1);
    }
}
