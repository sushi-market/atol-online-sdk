<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentRegistration;

final readonly class ReceivePaymentsOperatorDTO
{
    public function __construct(
        public array $phones,
    ) {}
}
