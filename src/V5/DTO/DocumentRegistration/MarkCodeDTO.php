<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentRegistration;

final readonly class MarkCodeDTO
{
    public function __construct(
        public ?string $unknown = null,
        public ?string $ean8 = null,
        public ?string $ean13 = null,
        public ?string $itf14 = null,
        public ?string $gs10 = null,
        public ?string $gs1m = null,
        public ?string $short = null,
        public ?string $fur = null,
        public ?string $egais20 = null,
        public ?string $egais30 = null,
    ) {}
}
