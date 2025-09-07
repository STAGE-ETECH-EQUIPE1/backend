<?php

namespace App\Tests\Request\Auth;

use App\Request\Auth\UpdatePasswordRequest;
use App\Tests\Request\RequestTestCase;

/**
 * @extends RequestTestCase<UpdatePasswordRequest>
 */
class UpdatePasswordRequestTest extends RequestTestCase
{
    protected array $validContent = [
        'currentPassword' => 'Admin@123',
        'newPassword' => 'Azerty@321',
        'confirmPassword' => 'Azerty@321',
    ];

    protected string $requestClass = UpdatePasswordRequest::class;

    public function testValidRequest(): void
    {
        $this->assertHasErrors($this->getRequest());
    }

    public function testInvalidRequest(): void
    {
        $this->assertHasErrors(
            $this->getRequest([
                'currentPassword' => '',
                'newPassword' => '',
                'confirmPassword' => '',
            ]), 3
        );
    }

    public function testNotSameNewAndConfirmPassword(): void
    {
        $this->assertHasErrors(
            $this->getRequest([
                'currentPassword' => '',
            ]), 1
        );
    }

    public function testBlankInput(): void
    {
        $this->assertHasErrors(
            $this->getRequest([
                'currentPassword' => '',
            ]), 1
        );
    }
}
