<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\Products;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Products::create([
            'name' => 'Ombak Water Purifier',
            'category' => 1,
            'price'=> 20000000,
            'stock'=>10,
        ]);

        Products::create([
            'name' => 'Villaem Water Purifier',
            'category' => 1,
            'price'=> 18000000,
            'stock'=> 5,
        ]);

        Products::create([
            'name' => 'Core Water Purifier',
            'category' => 1,
            'price'=> 17000000,
            'stock'=> 7,
        ]);

        Products::create([
            'name' => 'Triple Power Air Purifier',
            'category' => 2,
            'price'=> 10000000,
            'stock'=> 0,
        ]);

        Products::create([
            'name' => 'Storm Air Purifier',
            'category' => 2,
            'price'=> 9000000,
            'stock'=> 1,
        ]);

        Products::create([
            'name' => 'Breeze',
            'category' => 2,
            'price'=> 8000000,
            'stock'=> 28,
        ]);
    }
}
