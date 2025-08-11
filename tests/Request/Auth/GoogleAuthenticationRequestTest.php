<?php

namespace App\Tests\Request\Auth;

use App\Request\Auth\GoogleAuthenticationRequest;
use App\Tests\Request\RequestTestCase;

/**
 * @extends RequestTestCase<GoogleAuthenticationRequest>
 */
class GoogleAuthenticationRequestTest extends RequestTestCase
{
    protected array $validContent = [
        'access_token' => 'token',
    ];

    protected string $requestClass = GoogleAuthenticationRequest::class;

    public function testValidRequest(): void
    {
        $this->assertHasErrors($this->getRequest());
    }

    public function testInvalidRequest(): void
    {
        $this->assertHasErrors(
            $this->getRequest([
                'access_token' => '',
            ]), 1
        );
    }
}
