<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\Shared;

readonly class ErrorResponseDTO
{
    public function __construct(
        public ErrorDTO $error,
        public string $timestamp,
    ) {}
}
