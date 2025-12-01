<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentInfo;

use DF\AtolOnline\V5\DTO\Shared\ErrorDTO;

final readonly class DocumentInfoResponseDTO
{
    public function __construct(
        public string $uuid,
        public string $timestamp,
        public string $group_code,
        public string $daemon_code,
        public string $device_code,
        public ?PayloadDTO $payload = null,
        public ?ErrorDTO $error = null,
        public ?string $external_id = null,
        public ?string $callback_url = null,
        public ?Status $status = null,
        public ?WarningsDTO $warnings = null,
    ) {}
}
