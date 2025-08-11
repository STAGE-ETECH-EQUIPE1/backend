<?php

namespace App\Tests\Request\Logo;

use App\Request\Logo\CommentLogoRequest;
use App\Tests\Request\RequestTestCase;

/**
 * @extends RequestTestCase<CommentLogoRequest>
 */
class CommentLogoRequestTest extends RequestTestCase
{
    protected array $validContent = [
        'comment' => 'A lot of comment here !',
    ];

    protected string $requestClass = CommentLogoRequest::class;

    public function testValidRequest(): void
    {
        $this->assertHasErrors($this->getRequest());
    }

    public function testInvalidRequest(): void
    {
        $this->assertHasErrors(
            $this->getRequest([
                'comment' => '',
            ]), 2
        );
    }

    public function testLengthValidation(): void
    {
        $this->assertHasErrors(
            $this->getRequest([
                'comment' => 'a',
            ]), 1
        );
    }
}
