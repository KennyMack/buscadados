<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 20/08/2017
 * Time: 23:28
 */

namespace App\Utils;


class ConvDecimal
{
    public static function StrToDecimal($value)
    {
        $value = str_replace(",",".",$value);
        $value = preg_replace('/\.(?=.*\.)/', '', $value);
        return floatval($value);

    }

}