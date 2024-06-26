<?php

namespace App\Helpers;

class PriceHelper
{

    public static function fromStrToFloat(string $priceStr) : float
    {
        if (strlen($priceStr) > 6) { // more than 999.99
            $posDot = strpos($priceStr, ',');
            if ($posDot !== false && $posDot > 2) {
                $numericStr = str_replace(',', '.', $priceStr);
            } else {
                $numericStr = str_replace(',', '', $priceStr);
            }
        } else { // less than 1000
            $posDot = strpos($priceStr, '.');
            if ($posDot !== false) {
                $decStr = substr($priceStr, $posDot + 1);
                if ($decStr === '00') { // remove .00
                    $priceStr = substr($priceStr, 0, $posDot);
                }
            }
            $posComma = strpos($priceStr, ',');
            if ($posComma !== false) {
                $decStr = substr($priceStr, $posComma + 1);
                if ($decStr === '00') { // remove ,00
                    $priceStr = substr($priceStr, 0, $posComma);
                }
            }
            $numericStr = preg_replace("/[^0-9,]/", "", $priceStr);
            $numericStr = str_replace(",", ".", $numericStr);
        }

        return (float) $numericStr;
    }

    public static function fromFloatToStr($numericValue) : string
    {
        $formattedString = number_format($numericValue, 2, ',', '.');
        return '€' . $formattedString;
    }
}
