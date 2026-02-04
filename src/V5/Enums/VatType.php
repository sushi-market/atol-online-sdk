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
    case VAT_22 = 'vat22';

    case VAT_105 = 'vat105';
    case VAT_107 = 'vat107';
    case VAT_110 = 'vat110';
    case VAT_120 = 'vat120';
    case VAT_122 = 'vat122';

    public function getDescription(): string
    {
        return match ($this) {
            self::NONE => 'Без НДС',

            self::VAT_0 => 'НДС по ставке 0%',
            self::VAT_5 => 'НДС по ставке 5%',
            self::VAT_7 => 'НДС по ставке 7%',
            self::VAT_10 => 'НДС по ставке 10%',
            self::VAT_20 => 'НДС по ставке 20%',
            self::VAT_22 => 'НДС по ставке 22%',

            self::VAT_105 => 'НДС по расчетной ставке 5/105',
            self::VAT_107 => 'НДС по расчетной ставке 7/107',
            self::VAT_110 => 'НДС по расчетной ставке 10/110',
            self::VAT_120 => 'НДС по расчетной ставке 20/120',
            self::VAT_122 => 'НДС по расчетной ставке 22/122',
        };
    }

    public function percent(): float
    {
        return match ($this) {
            self::VAT_0, self::NONE => 0.0,
            self::VAT_5, self::VAT_105 => 5.0,
            self::VAT_7, self::VAT_107 => 7.0,
            self::VAT_10, self::VAT_110 => 10.0,
            self::VAT_20, self::VAT_120 => 20.0,
            self::VAT_22, self::VAT_122 => 22.0,
        };
    }

    /**
     * Начисляет НДС на сумму (из цены без НДС делает цену с НДС).
     *
     * Пример:
     * <code>
     * VatType::VAT_20->applyVat(1000.00);
     * // 1200.00
     * </code>
     */
    public function applyVat(float $amount): float
    {
        $vat = $amount * ($this->percent() / 100);

        return round(
            num: $amount + $vat,
            precision: 2,
        );
    }

    /**
     * Выделяет сумму НДС из цены с НДС.
     *
     * Пример:
     * <code>
     * VatType::VAT_20->extractVat(1200.00);
     * // 200.00
     * </code>
     */
    public function extractVat(float $amountWithVat): float
    {
        $vat = $amountWithVat * ($this->percent() / (100 + $this->percent()));

        return round($vat, 2);
    }

    /**
     * Возвращает сумму без НДС из суммы с НДС.
     *
     * Пример:
     * <code>
     * VatType::VAT_20->removeVat(1200.00);
     * // 1000.00
     * </code>
     */
    public function removeVat(float $amountWithVat): float
    {
        $vat = $this->extractVat($amountWithVat);

        return round($amountWithVat - $vat, 2);
    }
}
