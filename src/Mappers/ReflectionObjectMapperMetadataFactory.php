<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DF\AtolOnline\Mappers;

use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\ObjectMapper\Exception\MappingException;
use Symfony\Component\ObjectMapper\Metadata\Mapping;
use Symfony\Component\ObjectMapper\Metadata\ObjectMapperMetadataFactoryInterface;

/**
 * @internal
 *
 * @author Antoine Bluchet <soyuka@gmail.com>
 */
final class ReflectionObjectMapperMetadataFactory implements ObjectMapperMetadataFactoryInterface
{
    private array $reflectionClassCache = [];
    private array $attributesCache = [];

    public function create(object $object, ?string $property = null, array $context = []): array
    {
        try {
            $key = $object::class.($property ?? '');

            // Base mappings
            if (!isset($this->attributesCache[$key])) {
                $refl = $this->reflectionClassCache[$object::class] ??= new \ReflectionClass($object);

                $attributes = ($property && $refl->hasProperty($property) ? $refl->getProperty($property) : $refl)->getAttributes(Map::class, \ReflectionAttribute::IS_INSTANCEOF);

                $mappings = [];
                foreach ($attributes as $attribute) {
                    $map = $attribute->newInstance();
                    $mappings[] = new Mapping($map->target, $map->source, $map->if, $map->transform);
                }
                $this->attributesCache[$key] = $mappings;
            }

            $mappings = $this->attributesCache[$key];

            // Enrich mappings with EnumTransformer (if target context is provided)
            if ($property) {
                $mappings = $this->enrichWithEnumTransformer($object, $property, $mappings, $context);
            }

            return $mappings;
        } catch (\ReflectionException $e) {
            throw new MappingException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param list<Mapping> $mappings
     *
     * @return list<Mapping>
     */
    private function enrichWithEnumTransformer(object $object, string $property, array $mappings): array
    {
        $sourceRefl = $this->reflectionClassCache[$object::class] ??= new \ReflectionClass($object);

        if (!$sourceRefl->hasProperty($property)) {
            return $mappings;
        }

        $sourceTypeName = $sourceRefl->getProperty($property)->getType();

        $enumTransformer = $this->detectEnumTransformer($sourceTypeName);
        $enrichedMappings[] = new Mapping(null, null, null, $enumTransformer);

        return $enrichedMappings ?: $mappings;
    }

    private function detectEnumTransformer(string $sourceTypeName): ?MapEnum
    {
        if (is_a($sourceTypeName, \BackedEnum::class, true)) {
            return new MapEnum($sourceTypeName);
        }

        return null;
    }
}