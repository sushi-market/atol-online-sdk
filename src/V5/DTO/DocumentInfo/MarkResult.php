<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentInfo;

enum MarkResult: int
{
    case NOT_CHECKED_STATUS_UNKNOWN = 0;
    case FN_NEGATIVE_STATUS_UNKNOWN = 1;
    case POSITIVE_STATUS_UNKNOWN = 3;
    case NOT_CHECKED_STATUS_UNKNOWN_OFFLINE = 16;
    case FN_NEGATIVE_STATUS_UNKNOWN_OFFLINE = 17;
    case POSITIVE_STATUS_UNKNOWN_OFFLINE = 19;
    case NEGATIVE_STATUS_INCORRECT = 5;
    case POSITIVE_STATUS_INCORRECT = 7;
    case POSITIVE_STATUS_CORRECT = 15;

    public function getDescription(): string
    {
        return match ($this) {
            self::NOT_CHECKED_STATUS_UNKNOWN => 'Проверка не выполнена, статус товара ОИСМ не проверен',
            self::FN_NEGATIVE_STATUS_UNKNOWN => 'Проверка выполнена в ФН с отрицательным результатом, статус товара ОИСМ не проверен',
            self::POSITIVE_STATUS_UNKNOWN => 'Проверка выполнена с положительным результатом, статус товара ОИСМ не проверен',
            self::NOT_CHECKED_STATUS_UNKNOWN_OFFLINE => 'Проверка не выполнена, статус товара ОИСМ не проверен (автономный режим)',
            self::FN_NEGATIVE_STATUS_UNKNOWN_OFFLINE => 'Проверка выполнена в ФН с отрицательным результатом, статус товара ОИСМ не проверен (автономный режим)',
            self::POSITIVE_STATUS_UNKNOWN_OFFLINE => 'Проверка выполнена в ФН с положительным результатом, статус товара ОИСМ не проверен (автономный режим)',
            self::NEGATIVE_STATUS_INCORRECT => 'Проверка выполнена с отрицательным результатом, статус товара у ОИСМ некорректен',
            self::POSITIVE_STATUS_INCORRECT => 'Проверка выполнена с положительным результатом, статус товара у ОИСМ некорректен',
            self::POSITIVE_STATUS_CORRECT => 'Проверка выполнена с положительным результатом, статус товара у ОИСМ корректен',
        };
    }

    public function binary(): string
    {
        return match ($this) {
            self::NOT_CHECKED_STATUS_UNKNOWN => '00000000',
            self::FN_NEGATIVE_STATUS_UNKNOWN => '00000001',
            self::POSITIVE_STATUS_UNKNOWN => '00000011',
            self::NOT_CHECKED_STATUS_UNKNOWN_OFFLINE => '00010000',
            self::FN_NEGATIVE_STATUS_UNKNOWN_OFFLINE => '00010001',
            self::POSITIVE_STATUS_UNKNOWN_OFFLINE => '00010011',
            self::NEGATIVE_STATUS_INCORRECT => '00000101',
            self::POSITIVE_STATUS_INCORRECT => '00000111',
            self::POSITIVE_STATUS_CORRECT => '00001111',
        };
    }
}
