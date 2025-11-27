<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\Enums;

enum ErrorType: string
{
    case UNKNOWN = 'unknown';
    case SYSTEM = 'system';
    case DRIVER = 'driver';
    case TIMEOUT = 'timeout';
}
