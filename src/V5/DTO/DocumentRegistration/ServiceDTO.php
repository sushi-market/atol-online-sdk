<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentRegistration;

final readonly class ServiceDTO
{
    public function __construct(
        public string $callback_url,
    ) {}
}
