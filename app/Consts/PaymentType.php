<?php
namespace App\Consts;


class PaymentType
{
    const status1 = 1;
    const status12 = 12;
    const status24 = 24;
    const status36 = 36;

    public static function toString($code)
    {
        if(!isset($code)||empty($code))
        {
            return 'Unknown';
        }

        $arrStr = [
            self::status1 => 'Tunai',
            self::status12 => 'Cicilan 12 Bulan',
            self::status24 => 'Cicilan 24 Bulan',
            self::status36 => 'Cicilan 36 Bulan',
        ];

        if(empty($arrStr)){
            return 'Unknown';
        }
        return $arrStr[$code];
    }


}