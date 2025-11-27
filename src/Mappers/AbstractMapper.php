<?php

declare(strict_types=1);

namespace DF\AtolOnline\Mappers;

use BackedEnum;
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

    public static function toArray($DTO): array
    {
        $result = (array) $DTO;

        foreach ($result as $key => $item) {
            $result[$key] = match (true) {
                $item instanceof BackedEnum => $item->value,
                is_object($item), is_array($item) => self::toArray($item),
                default => $item,
            };
        }

        return array_filter($result, fn ($value) => $value !== null);
    }
}
