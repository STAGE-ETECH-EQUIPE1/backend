<?php

namespace App\Tests\Request;

use App\Tests\Trait\ValidationTestTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * @template T of object
 */
abstract class RequestTestCase extends KernelTestCase
{
    use ValidationTestTrait;

    protected array $validContent = [];

    /**
     * @var class-string<T>
     */
    protected string $requestClass;

    /**
     * @param array|null $updatedContent
     * @return T
     */
    public function getRequest(?array $updatedContent = null): mixed
    {
        return new $this->requestClass($this->createRequest($updatedContent));
    }

    public function createRequest(?array $content = null): Request
    {
        return new Request([], [], [], [], [], [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ], (string) json_encode($content ? $this->newContent($content) : $this->validContent));
    }

    private function newContent(array $updatedContent): array
    {
        return [...$this->validContent, ...$updatedContent];
    }

    abstract public function testValidRequest(): void;

    abstract public function testInvalidRequest(): void;
}
