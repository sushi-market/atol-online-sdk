<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentRegistration;

final readonly class DocumentRegistrationRequestDTO
{
    public function __construct(
        public ReceiptDTO $receipt,
        public string $external_id,
        public string $timestamp,
        public ?ServiceDTO $service = null,
        public bool $ism_optional = false,
        public ?int $source_id = null,
    ) {}
}
