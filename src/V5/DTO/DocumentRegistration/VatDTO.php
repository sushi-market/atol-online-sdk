<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentRegistration;

use DF\AtolOnline\V5\Enums\VatType;

final readonly class VatDTO
{
    public function __construct(
        public VatType $type,
        public float $sum,
    ) {}
}
