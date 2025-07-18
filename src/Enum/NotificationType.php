<?php

namespace App\Enum;

enum NotificationType: string
{
    case SUCCESS = 'success';

    case WARNING = 'updated';

    case ERROR = 'error';
}
