<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\Mappers;

use DF\AtolOnline\Mappers\AbstractMapper;
use DF\AtolOnline\V5\DTO\Shared\ErrorDTO;
use DF\AtolOnline\V5\Enums\ErrorType;

final class ErrorMapper extends AbstractMapper
{
    public static function fromArray(array $data): ErrorDTO
    {
        return new ErrorDTO(
            error_id: $data['error_id'],
            code: $data['code'],
            text: $data['text'],
            type: isset($data['type'])
                ? ErrorType::tryFrom($data['type'])
                : null,
        );
    }
}
