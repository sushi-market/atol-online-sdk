<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * https://github.com/symfony/symfony/pull/62392
 */

namespace DF\AtolOnline\Mappers;

use Symfony\Component\ObjectMapper\Exception\MappingTransformException;
use Symfony\Component\ObjectMapper\TransformCallableInterface;

/**
 * Transforms values between BackedEnum and their scalar representation.
 *
 * This transformer handles bidirectional conversion:
 * - BackedEnum -> int|string (extracts the backing value)
 * - int|string -> BackedEnum (creates enum from scalar)
 *
 * @implements TransformCallableInterface<object, object>
 *
 * @author Julien Robic <ayte91@gmail.com>
 */
final readonly class MapEnum implements TransformCallableInterface
{
    /**
     * @param string $targetType The target type: 'int', 'string', or a BackedEnum class-string
     */
    public function __construct(
        private string $targetType,
    ) {
    }

    public function __invoke(mixed $value, object $source, ?object $target): mixed
    {
        if (null === $value) {
            return null;
        }

        // BackedEnum -> scalar
        if ($value instanceof \BackedEnum && \in_array($this->targetType, ['int', 'string'], true)) {
            return $this->fromBackedEnum($value);
        }

        // Pure enum -> scalar (not allowed)
        if ($value instanceof \UnitEnum && !$value instanceof \BackedEnum && \in_array($this->targetType, ['int', 'string'], true)) {
            throw new MappingTransformException(\sprintf('Cannot convert pure enum "%s" to scalar type "%s". Only BackedEnum can be converted to scalar values.', $value::class, $this->targetType));
        }

        // scalar -> BackedEnum
        if (is_a($this->targetType, \BackedEnum::class, true) && !\is_object($value)) {
            return $this->toBackedEnum($value);
        }

        // scalar -> pure enum (not allowed)
        if (is_a($this->targetType, \UnitEnum::class, true) && !is_a($this->targetType, \BackedEnum::class, true) && !\is_object($value)) {
            throw new MappingTransformException(\sprintf('Cannot convert "%s" to pure enum "%s". Pure enums cannot be created from scalar values.', get_debug_type($value), $this->targetType));
        }

        return $value;
    }

    private function fromBackedEnum(\BackedEnum $enum): int|string
    {
        $backingType = get_debug_type($enum->value);

        if ($backingType !== $this->targetType) {
            throw new MappingTransformException(\sprintf('Cannot convert "%s"-backed enum "%s" to "%s".', $backingType, $enum::class, $this->targetType));
        }

        return $enum->value;
    }

    /**
     * @return \BackedEnum
     */
    private function toBackedEnum(int|string $value): \BackedEnum
    {
        $refl = new \ReflectionEnum($this->targetType);
        $backingType = $refl->getBackingType();
        $expectedType = $backingType instanceof \ReflectionNamedType ? $backingType->getName() : (string) $backingType;
        $actualType = get_debug_type($value);

        if ($expectedType !== $actualType) {
            throw new MappingTransformException(\sprintf('Cannot convert "%s" to "%s"-backed enum "%s".', $actualType, $expectedType, $this->targetType));
        }

        try {
            return $this->targetType::from($value);
        } catch (\ValueError $e) {
            throw new MappingTransformException(\sprintf('Invalid value "%s" for enum "%s": %s', $value, $this->targetType, $e->getMessage()), 0, $e);
        }
    }
}
