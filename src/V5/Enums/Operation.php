<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\Enums;

enum Operation: string
{
    case SELL = 'sell';
    case SELL_REFUND = 'sell_refund';
    case SELL_CORRECTION = 'sell_correction';
    case SELL_REFUND_CORRECTION = 'sell_refund_correction';

    case BUY = 'buy';
    case BUY_REFUND = 'buy_refund';
    case BUY_CORRECTION = 'buy_correction';
    case BUY_REFUND_CORRECTION = 'buy_refund_correction';
}
