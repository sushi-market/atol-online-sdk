<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\Requests;

use DF\AtolOnline\Enums\HttpAuthType;
use DF\AtolOnline\Enums\HttpMethod;
use DF\AtolOnline\Interfaces\ApiRequestInterface;

final readonly class DocumentInfoRequest implements ApiRequestInterface
{
    public function __construct(
        private string $groupCode,
        private string $uuid,
    ) {}

    public function getUri(): string
    {
        return "$this->groupCode/report/$this->uuid";
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getAuthType(): HttpAuthType
    {
        return HttpAuthType::API_KEY;
    }

    public function getQuery(): ?string
    {
        return null;
    }

    public function getBody(): null
    {
        return null;
    }

    public function getHeaders(): array
    {
        return [];
    }
}
