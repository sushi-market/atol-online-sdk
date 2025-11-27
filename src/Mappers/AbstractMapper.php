<?php

declare(strict_types=1);

namespace DF\AtolOnline\Mappers;

use JsonException;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractMapper
{
    abstract public static function fromArray(array $data);

    /**
     * <code>
     * public static function fromJsonResponse(ResponseInterface $response): ResponseDTO
     * {
     *     return parent::fromJsonResponse($response);
     * }
     * </code>
     *
     * @throws JsonException
     */
    public static function fromJsonResponse(ResponseInterface $response)
    {
        return static::fromArray(
            data: json_decode(
                json: $response->getBody()->getContents() ?: '[]',
                associative: true,
                flags: JSON_BIGINT_AS_STRING | JSON_THROW_ON_ERROR,
            ),
        );
    }
}
