<?php

namespace App\Enum;

enum SubscriptionStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case EXPIRED = 'expired';
    case PENDING = 'pending';
    case CANCELED = 'canceled';
}
