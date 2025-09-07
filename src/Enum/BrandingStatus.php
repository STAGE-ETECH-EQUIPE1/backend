<?php

namespace App\Enum;

enum BrandingStatus: string
{
    case ACTIVE = 'active';

    case INACTIVE = 'inactive';

    case PENDING = 'pending';
}
