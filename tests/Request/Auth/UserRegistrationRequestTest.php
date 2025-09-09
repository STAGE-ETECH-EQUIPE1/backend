<?php

namespace App\Tests\Request\Auth;

use App\Request\Auth\UserRegistrationRequest;
use App\Tests\Request\RequestTestCase;

/**
 * @extends RequestTestCase<UserRegistrationRequest>
 */
class UserRegistrationRequestTest extends RequestTestCase
{
    protected array $validContent = [
        'email' => 'admin@domain.com',
        'phone' => '0123456789',
        'fullName' => 'Admin User',
        'username' => 'admin.user',
        'password' => 'Admin@123',
        'confirmPassword' => 'Admin@123',
    ];

    protected string $requestClass = UserRegistrationRequest::class;

    public function testValidRequest(): void
    {
        $this->assertHasErrors($this->getRequest());
    }

    public function testInvalidRequest(): void
    {
        $this->assertHasErrors(
            $this->getRequest([
                'email' => '',
                'phone' => '',
                'fullName' => '',
                'username' => '',
                'password' => '',
                'confirmPassword' => '',
            ]), 6
        );
    }

    public function testNotSameNewAndConfirmPassword(): void
    {
        $this->assertHasErrors(
            $this->getRequest([
                'confirmPassword' => '123',
            ]), 1
        );
    }

    public function testBlankInput(): void
    {
        $this->assertHasErrors(
            $this->getRequest([
                'email' => '',
            ]), 1
        );
    }
}
