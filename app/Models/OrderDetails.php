<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{

    protected $fillable = ['orders_id','products_id','name','qty','price','total'];
   
}
