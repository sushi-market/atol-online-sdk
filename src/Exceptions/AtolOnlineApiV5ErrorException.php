<?php

declare(strict_types=1);

namespace DF\AtolOnline\Exceptions;

use DF\AtolOnline\V5\DTO\Shared\ErrorResponseDTO;
use RuntimeException;

class AtolOnlineApiV5ErrorException extends RuntimeException implements AtolOnlineException
{
    public function __construct(
        ErrorResponseDTO $errorResponseDTO,
    ) {
        parent::__construct(
            message: $errorResponseDTO->error->text,
            code: $errorResponseDTO->error->code,
        );
    }
}
