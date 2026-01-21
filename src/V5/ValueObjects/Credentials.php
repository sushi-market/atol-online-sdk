<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\ValueObjects;

use DF\AtolOnline\Exceptions\InvalidCredentialsException;

final readonly class Credentials
{
    public function __construct(
        public string $login,
        public string $password,
        public string $groupCode,
    ) {
        if ($this->login === '') {
            throw new InvalidCredentialsException('Parameter $login cannot be empty');
        }

        if ($this->password === '') {
            throw new InvalidCredentialsException('Parameter $password cannot be empty');
        }

        if ($this->groupCode === '') {
            throw new InvalidCredentialsException('Parameter $groupCode cannot be empty');
        }
    }
}
