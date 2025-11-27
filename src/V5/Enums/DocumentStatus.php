<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\Enums;

enum DocumentStatus: string
{
    case FAIL = 'fail';
    case WAIT = 'wait';

    public function getDescription(): string
    {
        return match ($this) {
            self::FAIL => 'Ошибка',
            self::WAIT => 'В обработке',
        };
    }
}
