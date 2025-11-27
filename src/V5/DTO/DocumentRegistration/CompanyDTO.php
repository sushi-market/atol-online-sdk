<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentRegistration;

use DF\AtolOnline\V5\Enums\TaxSystem;

final readonly class CompanyDTO
{
    public function __construct(
        public string $email,
        public TaxSystem $sno,
        public string $inn,
        public string $payment_address,
        public ?string $location = null,
    ) {}
}
