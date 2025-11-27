<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentRegistration;

final readonly class SectoralItemPropDTO
{
    public function __construct(
        public string $federal_id,
        public string $date,
        public string $number,
        public string $value,
    ) {}
}
