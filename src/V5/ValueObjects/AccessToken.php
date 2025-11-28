<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\ValueObjects;

final readonly class AccessToken
{
    public function __construct(
        public string $value,
    ) {}

    public function __toString(): string
    {
        return $this->value;
    }
}
