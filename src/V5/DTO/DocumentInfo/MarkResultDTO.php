<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentInfo;

final readonly class MarkResultDTO
{
    public function __construct(
        public float $position,
        public string $mark_code,
        public MarkResult $result,
    ) {}
}
