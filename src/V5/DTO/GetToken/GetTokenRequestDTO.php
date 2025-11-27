<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\GetToken;

final readonly class GetTokenRequestDTO
{
    public function __construct(
        public string $login,
        public string $pass,
        public ?string $source = null,
    ) {}
}
