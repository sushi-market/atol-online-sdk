<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\GetToken;

use DF\AtolOnline\V5\DTO\Shared\ErrorDTO;

final readonly class GetTokenResponseDTO
{
    public function __construct(
        public string $token,
        public string $timestamp,
        public ?ErrorDTO $error = null,
    ) {}
}
