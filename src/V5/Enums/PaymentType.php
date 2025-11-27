<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\Enums;

enum PaymentType: int
{
    case CASH = 0;
    case CASHLESS = 1;
    case PREPAYMENT = 2;
    case CREDIT = 3;
    case OTHER = 4;

    case EXTENDED_CASH = 5;
    case EXTENDED_CASHLESS = 6;
    case EXTENDED_PREPAYMENT = 7;
    case EXTENDED_CREDIT = 8;
    case EXTENDED_OTHER = 9;

    public function getDescription(): string
    {
        return match ($this) {
            self::CASH => 'Наличные',
            self::CASHLESS => 'Безналичные',
            self::PREPAYMENT => 'Предварительная оплата',
            self::CREDIT => 'Кредит',
            self::OTHER => 'Иная форма оплаты',

            self::EXTENDED_CASH => 'Наличные (расширенный)',
            self::EXTENDED_CASHLESS => 'Безналичные (расширенный)',
            self::EXTENDED_PREPAYMENT => 'Предварительная оплата (расширенный)',
            self::EXTENDED_CREDIT => 'Кредит (расширенный)',
            self::EXTENDED_OTHER => 'Иная форма оплаты (расширенный)',
        };
    }
}
