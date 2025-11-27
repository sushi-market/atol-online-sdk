<?php

declare(strict_types=1);

namespace DF\AtolOnline\Interfaces;

use DF\AtolOnline\Enums\HttpAuthType;
use DF\AtolOnline\Enums\HttpMethod;

interface ApiRequestInterface
{
    public function getUri(): string;

    public function getMethod(): HttpMethod;

    public function getAuthType(): HttpAuthType;

    public function getQuery(): ?string;

    public function getBody(): ?array;

    public function getHeaders(): array;
}
