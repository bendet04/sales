<?php
namespace App\Consts;


class PaymentStatus
{
    const status1 = 1;
    const status2 = 2;
    const status3 = 3;

    public static function toString($code)
    {
        if(!isset($code)||empty($code))
        {
            return 'Unknown';
        }

        $arrStr = [
            self::status1 => 'Belum Lunas',
            self::status2 => 'Sudah Lunas',
            self::status3 => 'Pengembalian Dana',
        ];

        if(empty($arrStr)){
            return 'Unknown';
        }
        return $arrStr[$code];
    }
}