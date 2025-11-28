<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\Storage;

use DF\AtolOnline\V5\ValueObjects\AccessToken;

final class TokenStorage
{
    public function __construct(
        public ?AccessToken $token = null,
    ) {}
}
