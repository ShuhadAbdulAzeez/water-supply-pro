<?php

namespace App\Helpers;

class CurrencyHelper
{
    public static function format($amount)
    {
        return 'AED ' . number_format($amount, 2);
    }
}