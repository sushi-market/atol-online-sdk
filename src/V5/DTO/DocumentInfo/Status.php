<?php

declare(strict_types=1);

namespace DF\AtolOnline\V5\DTO\DocumentInfo;

enum Status: string
{
    case DONE = 'done';
    case FAIL = 'fail';
    case WAIT = 'wait';

    public function getDescription(): string
    {
        return match ($this) {
            self::DONE => 'Зарегистрирован',
            self::FAIL => 'Ошибка',
            self::WAIT => 'В обработке',
        };
    }
}
