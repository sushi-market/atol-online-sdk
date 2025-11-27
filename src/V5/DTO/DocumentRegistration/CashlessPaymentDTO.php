<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentRegistration;

final readonly class CashlessPaymentDTO
{
    public function __construct(
        public float $sum,
        public int $method,
        public string $id,
        public string $additional_info,
    ) {}
}
