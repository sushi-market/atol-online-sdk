<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentCorrection;

use DF\AtolOnline\V5\Enums\CorrectionInfoType;

final readonly class CorrectionInfoDTO
{
    public function __construct(
        public CorrectionInfoType $type,
        public string $base_date,
        public ?string $base_number = null,
    ) {}
}
