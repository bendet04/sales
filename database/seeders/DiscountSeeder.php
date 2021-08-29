<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Discounts;

class discountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Discounts::create([
            'name'=>'All Items for Outright',
            'price'=> 2000000,
            'active_until' => '2021-04-04',
        ]);

        Discounts::create([
            'name'=>'Water Purifier for Installment',
            'price'=> 1000000,
            'active_until' => '2021-04-04',
        ]);
    }
}
