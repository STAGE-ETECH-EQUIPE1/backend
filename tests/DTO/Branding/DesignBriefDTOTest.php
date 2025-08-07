<?php

namespace App\Tests\DTO\Branding;

use App\DTO\Branding\DesignBriefDTO;
use App\Tests\DTO\ValidationTestTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DesignBriefDTOTest extends KernelTestCase
{
    use ValidationTestTrait;

    public function getDTO(): DesignBriefDTO
    {
        return (new DesignBriefDTO())
            ->setColorPreferences([
                'primary' => 'yellow',
                'secondary' => 'blue',
            ])
            ->setBrandKeywords([
                'company', 'branding',
            ])
            ->setDescription('A lot of description about company')
            ->setMoodBoardUrl('https://loremflickr.com/2806/86?lock=3860409461985729')
            ->setLogoStyle('modern')
            ->setSlogan('GrowUp together')
        ;
    }

    public function testValidDTO(): void
    {
        $this->assertHasErrors($this->getDTO());
    }

    public function testMinLengthDescription(): void
    {
        $this->assertHasErrors(
            $this->getDTO()->setDescription('1'),
            1);
    }

    public function testNullColorPreferences(): void
    {
        $this->assertHasErrors(
            $this->getDTO()->setColorPreferences([]),
            1);
    }

    public function testInvalidUrl(): void
    {
        $this->assertHasErrors(
            $this->getDTO()->setMoodBoardUrl('https:// loremflickr.com/2806/86?lock=3860409461985729'),
            1);
    }

    public function testNullBrandKeywords(): void
    {
        $this->assertHasErrors(
            $this->getDTO()->setBrandKeywords([]),
            1);
    }

    public function testInvalidMinLogoStyle(): void
    {
        $this->assertHasErrors(
            $this->getDTO()->setLogoStyle('a'),
            1);
    }
}
