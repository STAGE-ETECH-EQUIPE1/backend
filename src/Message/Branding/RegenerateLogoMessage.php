<?php

namespace App\Message\Branding;

use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage('async')]
final class RegenerateLogoMessage
{
    public function __construct(
        public readonly int $brandingId,
        public readonly int $briefId,
    ) {
    }
}
