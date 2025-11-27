<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\Enums;

enum PaymentMethod: string
{
    case FULL_PREPAYMENT = 'full_prepayment';
    case PREPAYMENT = 'prepayment';
    case ADVANCE = 'advance';
    case FULL_PAYMENT = 'full_payment';
    case PARTIAL_PAYMENT = 'partial_payment';
    case CREDIT = 'credit';
    case CREDIT_PAYMENT = 'credit_payment';

    public function getDescription(): string
    {
        return match ($this) {
            self::FULL_PREPAYMENT => 'Предоплата 100%',
            self::PREPAYMENT => 'Предоплата',
            self::ADVANCE => 'Аванс',
            self::FULL_PAYMENT => 'Полный расчет',
            self::PARTIAL_PAYMENT => 'Частичный расчет',
            self::CREDIT => 'Кредит',
            self::CREDIT_PAYMENT => 'Оплата кредита',
        };
    }
}
