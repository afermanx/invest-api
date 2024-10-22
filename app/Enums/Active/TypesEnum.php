<?php

namespace App\Enums\Active;

enum TypesEnum: string
{
    case action = 'action';
    case real_estate_fund = 'real_estate_fund';
    case fixed_income = 'fixed_income';
    case cryptocurrency = 'cryptocurrency';

    public static function getTypes(): array
    {
        return [
            self::action,
            self::real_estate_fund,
            self::fixed_income,
            self::cryptocurrency,
        ];
    }
}
