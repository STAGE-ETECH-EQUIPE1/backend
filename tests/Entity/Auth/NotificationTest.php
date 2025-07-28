<?php

namespace App\Tests\Entity\Auth;

use App\Entity\Auth\Notification;
use App\Enum\NotificationType;
use App\Factory\Auth\UserFactory;
use App\Tests\DTO\ValidationTestTrait;
use App\Tests\Entity\EntityTestCase;
use Zenstruck\Foundry\Test\Factories;

class NotificationTest extends EntityTestCase
{
    use ValidationTestTrait;
    use Factories;

    public function getEntity(): Notification
    {
        return (new Notification())
            ->setCreatedAt((new \DateTimeImmutable())::createFromMutable($this->getFaker()->dateTimeThisYear('now')))
            ->setOwner(UserFactory::new()->create())
            ->setContent($this->getFaker()->sentence())
            ->setType(NotificationType::INFO)
            ->setReadAt(null)
        ;
    }

    public function testValidEntity(): void
    {
        $this->assertHasErrors($this->getEntity());
    }
}
