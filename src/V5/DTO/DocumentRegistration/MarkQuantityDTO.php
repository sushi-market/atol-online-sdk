<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentRegistration;

final readonly class MarkQuantityDTO
{
    public function __construct(
        public int $numerator,
        public int $denominator,
    ) {}
}
