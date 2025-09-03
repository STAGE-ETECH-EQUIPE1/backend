<?php

namespace App\Event;

use App\Entity\Branding\LogoVersion;

final class PublishLogoEvent
{
    public function __construct(
        public LogoVersion $logo,
        public int $brandingId,
    ) {
    }
}
