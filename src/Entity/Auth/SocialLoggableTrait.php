<?php

namespace App\Entity\Auth;

use Doctrine\ORM\Mapping as ORM;

trait SocialLoggableTrait
{
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $googleId = null;
}
