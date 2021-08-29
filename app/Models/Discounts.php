<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discounts extends Model
{
    protected $fillable = ['name', 'price', 'active_until'];

    public function Order(){
        return $this->hasMany(Order::class);
    }
}
