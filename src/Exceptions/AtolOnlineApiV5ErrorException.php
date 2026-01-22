<?php

declare(strict_types=1);

namespace DF\AtolOnline\Exceptions;

use DF\AtolOnline\V5\DTO\Shared\ErrorDTO;
use RuntimeException;

class AtolOnlineApiV5ErrorException extends RuntimeException implements AtolOnlineException
{
    public function __construct(
        ErrorDTO $errorDTO,
    ) {
        parent::__construct(
            message: $errorDTO->text,
            code: $errorDTO->code,
        );
    }
}
