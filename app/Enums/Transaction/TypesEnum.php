<?php

namespace App\Enums\Transaction;

enum TypesEnum: string
{
    case BUY = 'buy';
    case SELL = 'sell';

    public static function getTypes(): array
    {
        return [
            self::buy,
            self::sell,
        ];
    }
}
