<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentRegistration;

final readonly class SupplierInfoDTO
{
    public function __construct(
        public string $inn,
        public array $phones,
        public string $name,
    ) {}
}
