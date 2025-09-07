<?php

namespace App\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RepositoryTestCase extends KernelTestCase
{
    // @phpstan-ignore missingType.property
    protected $repository;

    // @phpstan-ignore missingType.property
    protected $repositoryClass;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = self::getContainer()->get($this->repositoryClass);
    }
}
