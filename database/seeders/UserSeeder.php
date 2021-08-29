<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sales = User::create([
            'name'=>'adi sales',
            'email'=>'adi@sales.com',
            'password'=>bcrypt('12345678')
        ]);
        $sales->assignRole('sales');

        $admin1 = User::create([
            'name'=>'adi admin',
            'email'=> 'adi@admin.com',
            'password'=> bcrypt('12345678')
        ]);
        $admin1->assignRole('admin-1');

        $admin2 = User::create([
            'name'=>'adi admin 2',
            'email'=> 'adi@admin2.com',
            'password'=> bcrypt('12345678')
        ]);
        $admin2->assignRole('admin-2');

        $technician = User::create([
            'name'=>'adi technician',
            'email'=> 'adi@technician.com',
            'password'=> bcrypt('12345678')
        ]);
        $technician->assignRole('technician');
    }
}
