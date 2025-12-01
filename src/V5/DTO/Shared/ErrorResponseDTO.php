<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\Shared;

use DF\AtolOnline\V5\Enums\DocumentStatus;

readonly class ErrorResponseDTO
{
    public function __construct(
        public ErrorDTO $error,
        public string $timestamp,
        public ?DocumentStatus $status = null,
    ) {}
}
