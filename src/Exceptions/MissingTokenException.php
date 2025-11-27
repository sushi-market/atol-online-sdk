<?php

declare(strict_types=1);

namespace DF\AtolOnline\Exceptions;

use RuntimeException;

class MissingTokenException extends RuntimeException implements AtolOnlineException
{
    public function __construct()
    {
        parent::__construct(
            message: 'Missing authorization token',
        );
    }
}
