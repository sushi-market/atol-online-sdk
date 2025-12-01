<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\Requests;

use DF\AtolOnline\Enums\HttpAuthType;
use DF\AtolOnline\Enums\HttpMethod;
use DF\AtolOnline\Interfaces\ApiRequestInterface;
use DF\AtolOnline\V5\DTO\DocumentCorrection\DocumentCorrectionRequestDTO;
use DF\AtolOnline\V5\Enums\Operation;

final readonly class DocumentCorrectionRequest implements ApiRequestInterface
{
    public function __construct(
        private string $groupCode,
        private Operation $operation,
        private DocumentCorrectionRequestDTO $requestDTO,
    ) {}

    public function getUri(): string
    {
        return "$this->groupCode/{$this->operation->value}";
    }

    public function getMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getAuthType(): HttpAuthType
    {
        return HttpAuthType::API_KEY;
    }

    public function getQuery(): ?string
    {
        return null;
    }

    public function getBody(): DocumentCorrectionRequestDTO
    {
        return $this->requestDTO;
    }

    public function getHeaders(): array
    {
        return [];
    }
}
