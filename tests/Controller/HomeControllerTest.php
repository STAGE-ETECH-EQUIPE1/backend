<?php

namespace App\Tests\Controller;

class HomeControllerTest extends ApiControllerTestCase
{
    public function testIndex(): void
    {
        $this->apiClient()->request('GET', '/api/test');
        $this->assertResponseIsSuccessful();
    }
}
