<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentInfo;

final readonly class WarningsDTO
{
    public function __construct(
        public ?string $callback_url = null,
    ) {}
}
