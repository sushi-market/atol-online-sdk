<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\Enums;

enum VatType: string
{
    case NONE = 'none';

    case VAT_0 = 'vat0';
    case VAT_5 = 'vat5';
    case VAT_7 = 'vat7';
    case VAT_10 = 'vat10';
    case VAT_20 = 'vat20';

    case VAT_105 = 'vat105';
    case VAT_107 = 'vat107';
    case VAT_110 = 'vat110';
    case VAT_120 = 'vat120';

    public function getDescription(): string
    {
        return match ($this) {
            self::NONE => 'Без НДС',

            self::VAT_0 => 'НДС по ставке 0%',
            self::VAT_5 => 'НДС по ставке 5%',
            self::VAT_7 => 'НДС по ставке 7%',
            self::VAT_10 => 'НДС по ставке 10%',
            self::VAT_20 => 'НДС по ставке 20%',

            self::VAT_105 => 'НДС по расчетной ставке 5/105',
            self::VAT_107 => 'НДС по расчетной ставке 7/107',
            self::VAT_110 => 'НДС по расчетной ставке 10/110',
            self::VAT_120 => 'НДС по расчетной ставке 20/120',
        };
    }
}
