<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\Enums;

enum AgentType: string
{
    case BANK_PAYING_AGENT = 'bank_paying_agent';
    case BANK_PAYING_SUBAGENT = 'bank_paying_subagent';
    case PAYING_AGENT = 'paying_agent';
    case PAYING_SUBAGENT = 'paying_subagent';
    case ATTORNEY = 'attorney';
    case COMMISSION_AGENT = 'commission_agent';
    case ANOTHER = 'another';

    public function getDescription(): string
    {
        return match ($this) {
            self::BANK_PAYING_AGENT => 'Банковский платежный агент',
            self::BANK_PAYING_SUBAGENT => 'Банковский платежный субагент',
            self::PAYING_AGENT => 'Платежный агент',
            self::PAYING_SUBAGENT => 'Платежный субагент',
            self::ATTORNEY => 'Поверенный',
            self::COMMISSION_AGENT => 'Комиссионер',
            self::ANOTHER => 'Другой тип агента',
        };
    }
}
