<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\Mappers;

use DF\AtolOnline\Mappers\AbstractMapper;
use DF\AtolOnline\V5\DTO\DocumentRegistration\DocumentRegistrationResponseDTO;
use Psr\Http\Message\ResponseInterface;

final class DocumentRegistrationResponseMapper extends AbstractMapper
{
    public static function fromArray(array $data): DocumentRegistrationResponseDTO
    {
        return new DocumentRegistrationResponseDTO(
            uuid: $data['uuid'],
            timestamp: $data['timestamp'],
            status: $data['status'],
            error: $data['error'],
        );
    }

    public static function fromJsonResponse(ResponseInterface $response): DocumentRegistrationResponseDTO
    {
        return parent::fromJsonResponse($response);
    }
}
