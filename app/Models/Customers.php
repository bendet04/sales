<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $fillable = ['type','id_number', 'name','address', 'phone'];

    public function Order(){
        return $this->hasMany(Order::class);
    }

    public static function create($id, $params){
        return static::updateOrCreate(['id_number'=>$id], $params);
    }
}
