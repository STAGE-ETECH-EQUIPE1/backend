<?php

namespace App\Tests\Request\Branding;

use App\Request\Branding\DesignBriefRequest;
use App\Tests\Request\RequestTestCase;


/**
 * @extends RequestTestCase<DesignBriefRequest>
 */
class DesignBriefRequestTest extends RequestTestCase
{
    protected array $validContent = [
        'slogan' => 'slogan here',
        'logoStyle' => 'modern',
        'description' => 'a lot of description about logo',
        'colorPreferences' => [
            '#255429', '#140214',
        ],
        'brandKeywords' => [
            'Recruitment', 'Consultation', 'Creativity',
        ],
        'moodBoardUrl' => 'https://loremflickr.com/1358/2548?lock=398733073501128',
    ];

    protected string $requestClass = DesignBriefRequest::class;

    public function testValidRequest(): void
    {
        $this->assertHasErrors($this->getRequest());
    }

    public function testInvalidRequest(): void
    {
        $this->assertHasErrors(
            $this->getRequest([
                'slogan' => 'a',
                'logoStyle' => 'a',
                'description' => 'a',
                'colorPreferences' => [],
                'brandKeywords' => [],
                'moodBoardUrl' => '',
            ]), 5
        );
    }
}
