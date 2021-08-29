<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $fillable = ['orders_id','payment_number','payment_date','payment_status','price'];

    public static function genOrderNum()
    {
        $today = date('Y-m-d 00:00:00');
        $order = static::where('created_at', '>=',$today)->orderByDesc('id')->first();
        if (empty($order)) {
            $baseId = 1;
        } else {
            $number = $order->payment_number;
            $number = preg_match('/[\d]+$/',$number,$matchs);
            $baseId = (int)$matchs[0] + 1;
        }
        
        return 'P' . date('Ymd', time()) . rand(10, 99) . chr(rand(65, 90)) . str_pad($baseId, 3, 0, STR_PAD_LEFT);
    }
}
