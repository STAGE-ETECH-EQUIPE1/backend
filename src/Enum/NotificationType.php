<?php

namespace App\Enum;

enum NotificationType: string
{
    case INFO = 'info';

    case SUCCESS = 'success';

    case WARNING = 'updated';

    case ERROR = 'error';
}
