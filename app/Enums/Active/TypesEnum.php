<?php

namespace App\Enums\Active;

enum TypesEnum: string
{
    case ACTION = 'action';
    case REAL_ESTATE_FUND = 'real_estate_fund';
    case FIXED_INCOME = 'fixed_income';
    case CRYPTOCURRENCY = 'cryptocurrency';

    public static function getTypes(): array
    {
        return [
            self::ACTION,
            self::REAL_ESTATE_FUND,
            self::FIXED_INCOME,
            self::CRYPTOCURRENCY,
        ];
    }
}
