<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentRegistration;

use DF\AtolOnline\V5\DTO\Shared\ErrorDTO;
use DF\AtolOnline\V5\Enums\DocumentStatus;

final readonly class DocumentRegistrationResponseDTO
{
    public function __construct(
        public string $uuid,
        public DocumentStatus $status,
        public string $timestamp,
        public ?ErrorDTO $error = null,
    ) {}
}
