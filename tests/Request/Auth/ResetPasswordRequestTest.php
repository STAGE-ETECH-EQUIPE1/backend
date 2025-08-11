<?php

namespace App\Tests\Request\Auth;

use App\Request\Auth\ResetPasswordRequest;
use App\Tests\Request\RequestTestCase;

/**
 * @extends RequestTestCase<ResetPasswordRequest>
 */
class ResetPasswordRequestTest extends RequestTestCase
{
    protected array $validContent = [
        'email' => 'admin@domain.com',
    ];

    protected string $requestClass = ResetPasswordRequest::class;

    public function testValidRequest(): void
    {
        $this->assertHasErrors($this->getRequest());
    }

    public function testInvalidRequest(): void
    {
        $this->assertHasErrors(
            $this->getRequest([
                'email' => '',
            ]), 1
        );
    }
}
