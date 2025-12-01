<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\Requests;

use DF\AtolOnline\Enums\HttpAuthType;
use DF\AtolOnline\Enums\HttpMethod;
use DF\AtolOnline\Interfaces\ApiRequestInterface;
use DF\AtolOnline\V5\DTO\GetToken\GetTokenRequestDTO;

final readonly class GetTokenRequest implements ApiRequestInterface
{
    public function __construct(
        private GetTokenRequestDTO $requestDTO,
    ) {}

    public function getUri(): string
    {
        return 'getToken';
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getAuthType(): HttpAuthType
    {
        return HttpAuthType::NONE;
    }

    public function getQuery(): ?string
    {
        return null;
    }

    public function getBody(): GetTokenRequestDTO
    {
        return $this->requestDTO;
    }

    public function getHeaders(): array
    {
        return [];
    }
}
