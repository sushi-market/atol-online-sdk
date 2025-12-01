<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\Enums;

enum CorrectionInfoType: string
{
    case SELF = 'self';
    case INSTRUCTION = 'instruction';

    public function getDescription(): string
    {
        return match ($this) {
            self::SELF => 'Самостоятельная операция',
            self::INSTRUCTION => 'Операция по предписанию налогового органа об устранении
выявленного нарушения законодательства',
        };
    }
}
