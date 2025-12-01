<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\Mappers;

use DF\AtolOnline\Mappers\AbstractMapper;
use DF\AtolOnline\V5\DTO\DocumentInfo\DocumentInfoResponseDTO;
use DF\AtolOnline\V5\Enums\DocumentStatus;
use Psr\Http\Message\ResponseInterface;

final class DocumentInfoResponseMapper extends AbstractMapper
{
    public static function fromArray(array $data): DocumentInfoResponseDTO
    {
        return new DocumentInfoResponseDTO(
            uuid: $data['uuid'],
            timestamp: $data['timestamp'],
            group_code: $data['group_code'],
            daemon_code: $data['daemon_code'],
            device_code: $data['device_code'],
            error: !empty($data['payload'])
                ? ErrorMapper::fromArray($data['payload'])
                : null,

            error: !empty($data['error'])
                ? ErrorMapper::fromArray($data['error'])
                : null,
        );
    }

    public static function fromJsonResponse(ResponseInterface $response): DocumentInfoResponseDTO
    {
        return parent::fromJsonResponse($response);
    }
}
