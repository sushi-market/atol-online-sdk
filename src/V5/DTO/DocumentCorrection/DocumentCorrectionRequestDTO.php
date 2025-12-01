<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentCorrection;

use DF\AtolOnline\V5\DTO\DocumentRegistration\ServiceDTO;

final readonly class DocumentCorrectionRequestDTO
{
    public function __construct(
        public CorrectionDTO $correction,
        public string $external_id,
        public string $timestamp,
        public ?int $source_id = null,
        public ?ServiceDTO $service = null,
        public ?bool $ism_optional = null,
    ) {}
}
