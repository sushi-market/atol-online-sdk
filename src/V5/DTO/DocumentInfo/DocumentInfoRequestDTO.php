<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentInfo;

final readonly class DocumentInfoRequestDTO
{
    public function __construct(
        public string $uuid,
    ) {}
}
