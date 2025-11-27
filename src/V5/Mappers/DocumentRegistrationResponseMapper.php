<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\Mappers;

use DF\AtolOnline\Mappers\AbstractMapper;
use DF\AtolOnline\V5\DTO\DocumentRegistration\DocumentRegistrationResponseDTO;
use DF\AtolOnline\V5\Enums\DocumentStatus;
use Psr\Http\Message\ResponseInterface;

final class DocumentRegistrationResponseMapper extends AbstractMapper
{
    public static function fromArray(array $data): DocumentRegistrationResponseDTO
    {
        return new DocumentRegistrationResponseDTO(
            uuid: $data['uuid'],
            status: DocumentStatus::from($data['status']),
            timestamp: $data['timestamp'],
            error: !empty($data['error'])
                ? ErrorMapper::fromArray($data['error'])
                : null,
        );
    }

    public static function fromJsonResponse(ResponseInterface $response): DocumentRegistrationResponseDTO
    {
        return parent::fromJsonResponse($response);
    }
}
