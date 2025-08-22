<?php

namespace App\Message\Branding;

use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage('async')]
final class GenerateLogoMessage
{
    public function __construct(
        public readonly int $briefId,
    ) {
    }
}
