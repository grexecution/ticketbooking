<?php

namespace App\Helpers;

class PriceHelper
{
    public static function fromStrToFloat(string $priceStr) : float
    {
        $numericString = preg_replace("/[^0-9,]/", "", $priceStr);
        $numericString = str_replace(",", ".", $numericString);
        return (float) $numericString;
    }

    public static function fromFloatToStr($numericValue) : string
    {
        $formattedString = number_format($numericValue, 2, ',', '.');
        return '€' . $formattedString;
    }
}
