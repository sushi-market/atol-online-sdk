<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\Enums;

enum Timezone: int
{
    case UTC_2 = 1;
    case UTC_3 = 2;
    case UTC_4 = 3;
    case UTC_5 = 4;
    case UTC_6 = 5;
    case UTC_7 = 6;
    case UTC_8 = 7;
    case UTC_9 = 8;
    case UTC_10 = 9;
    case UTC_11 = 10;
    case UTC_12 = 11;

    public function getDescription(): string
    {
        return match ($this) {
            self::UTC_2 => 'МСК-1, московское время минус 1 час, UTC+2',
            self::UTC_3 => 'МСК, московское время, UTC+3',
            self::UTC_4 => 'МСК+1, московское время плюс 1 час, UTC+4',
            self::UTC_5 => 'МСК+2, московское время плюс 2 часа, UTC+5',
            self::UTC_6 => 'МСК+3, московское время плюс 3 часа, UTC+6',
            self::UTC_7 => 'МСК+4, московское время плюс 4 часа, UTC+7',
            self::UTC_8 => 'МСК+5, московское время плюс 5 часов, UTC+8',
            self::UTC_9 => 'МСК+6, московское время плюс 6 часов, UTC+9',
            self::UTC_10 => 'МСК+7, московское время плюс 7 часов, UTC+10',
            self::UTC_11 => 'МСК+8, московское время плюс 8 часов, UTC+11',
            self::UTC_12 => 'МСК+9, московское время плюс 9 часов, UTC+12',
        };
    }
}
