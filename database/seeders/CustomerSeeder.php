<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customers;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customers::insert([
            'type'=>1,
            'id_number'=>'3209310404930004',
            'name'=>'adi',
            'address'=>'jl. kemana',
            'phone'=>'087829845208',
        ]);
    }
}
