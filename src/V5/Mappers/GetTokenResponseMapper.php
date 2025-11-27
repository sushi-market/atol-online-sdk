<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\Mappers;

use DF\AtolOnline\Mappers\AbstractMapper;
use DF\AtolOnline\V5\DTO\GetToken\GetTokenResponseDTO;

final class GetTokenResponseMapper extends AbstractMapper
{
    public static function fromArray(array $data): GetTokenResponseDTO
    {
        return new GetTokenResponseDTO(
            token: $data['token'],
            timestamp: $data['timestamp'],
            error: !empty($data['error'])
                ? ErrorMapper::fromArray($data['error'])
                : null,
        );
    }
}
