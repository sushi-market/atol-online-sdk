<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\Shared;

use DF\AtolOnline\V5\Enums\ErrorType;

readonly class ErrorDTO
{
    public function __construct(
        public int $code,
        public string $text,
        public ?string $error_id = null,
        public ?ErrorType $type = null,
    ) {}
}
