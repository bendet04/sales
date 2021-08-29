<?php
namespace App\Utils;

class FormatCurrency 
{
    public static function toRupiah($amount){
	    return "Rp " . number_format($amount,0,',','.');
    }
}