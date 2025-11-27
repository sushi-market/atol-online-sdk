<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\Enums;

enum PlannedStatus: int
{
    case PIECE_SOLD = 1;
    case MEASURED_IN_PROGRESS = 2;
    case PIECE_RETURNED = 3;
    case PART_RETURNED = 4;
    case PIECE_IN_PROGRESS = 5;
    case MEASURED_SOLD = 6;

    public function getDescription(): string
    {
        return match ($this) {
            self::PIECE_SOLD => 'Штучный товар, реализован',
            self::MEASURED_IN_PROGRESS => 'Мерный товар, в стадии реализации',
            self::PIECE_RETURNED => 'Штучный товар, возвращен',
            self::PART_RETURNED => 'Часть товара, возвращена',
            self::PIECE_IN_PROGRESS => 'Штучный товар, в стадии реализации',
            self::MEASURED_SOLD => 'Мерный товар, реализован',
        };
    }
}
