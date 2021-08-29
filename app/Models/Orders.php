<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = ['order_number','customer_id','discount_id','installation_address','installation_date', 
    'pic_contact','document','order_status','total_price','discount_amount','grand_price','payment_scheme','payment_status'];

    public function customer(){
        return $this->belongsTo(Customers::class);
    }

    public function orderDetail(){
        return $this->hasMany(OrderDetails::class);
    }

    public function paymentDetail(){
        return $this->hasMany(Payments::class);
    }

    public function discount(){
        return $this->belongsTo(Discounts::class);
    }

    public static function genOrderNum()
    {
        $today = date('Y-m-d 00:00:00');
        $order = static::where('created_at', '>=',$today)->orderByDesc('id')->first();
        if (empty($order)) {
            $baseId = 1;
        } else {
            $number = $order->order_number;
            $number = preg_match('/[\d]+$/',$number,$matchs);
            $baseId = (int)$matchs[0] + 1;
        }
        
        return 'O' . date('Ymd', time()) . rand(10, 99) . chr(rand(65, 90)) . str_pad($baseId, 3, 0, STR_PAD_LEFT);
    }
}
