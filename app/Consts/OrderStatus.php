<?php
namespace App\Consts;


class OrderStatus
{
    const status1 = 1;
    const status2 = 2;
    const status3 = 3;
    const status4 = 4;
    const status5 = 5;
    const status6 = 6;
    const status7 = 7;
    const status8 = 8;

    public static function toString($code)
    {
        if(!isset($code)||empty($code))
        {
            return 'Unknown';
        }

        $arrStr = [
            self::status1 => 'Verifikasi Admin lvl 1',
            self::status2 => 'Persetujuan Admin Lvl 2',
            self::status3 => 'Jadwal Pemasangan',
            self::status8 => 'Pemasangan',
            self::status4 => 'Order Selesai',
            self::status5 => 'Ditolak Admin lvl 1',
            self::status6 => 'Ditolak Admin lvl 2',
            self::status7 => 'Order Dibatalkan',
        ];

        if(empty($arrStr)){
            return 'Unknown';
        }
        return $arrStr[$code];
    }


}