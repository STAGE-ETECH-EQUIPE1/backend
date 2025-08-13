<?php

namespace App\EventSubscriber;

use App\Event\PublishLogoEvent;
use App\Services\LogoGeneration\LogoGenerationServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PublishLogoSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly LogoGenerationServiceInterface $logoGenerationService,
    ) {
    }

    public function onPublishLogoEvent(PublishLogoEvent $event): void
    {
        $this->logoGenerationService->publishLogo($event->logo, $event->brandingId);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            PublishLogoEvent::class => 'onPublishLogoEvent',
        ];
    }
}
