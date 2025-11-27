<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentRegistration;

use DF\AtolOnline\V5\Enums\PaymentType;

final readonly class PaymentDTO
{
    public function __construct(
        public PaymentType $type,
        public float $sum,
    ) {}
}
