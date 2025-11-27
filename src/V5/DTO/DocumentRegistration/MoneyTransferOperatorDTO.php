<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentRegistration;

final readonly class MoneyTransferOperatorDTO
{
    public function __construct(
        public ?array $phones = null,
        public ?string $name = null,
        public ?string $address = null,
        public ?string $inn = null,
    ) {}
}
