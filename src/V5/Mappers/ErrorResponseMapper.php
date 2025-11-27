<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\Mappers;

use DF\AtolOnline\Mappers\AbstractMapper;
use DF\AtolOnline\V5\DTO\Shared\ErrorResponseDTO;
use Psr\Http\Message\ResponseInterface;

final class ErrorResponseMapper extends AbstractMapper
{
    public static function fromArray(array $data): ErrorResponseDTO
    {
        return new ErrorResponseDTO(
            error: ErrorMapper::fromArray($data['error']),
            timestamp: $data['timestamp'],
        );
    }

    public static function fromJsonResponse(ResponseInterface $response): ErrorResponseDTO
    {
        return parent::fromJsonResponse($response);
    }
}
