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
        $sales_user = User::create([
            'name'=>'adi sales',
            'email'=>'adi@sales.com',
            'password'=>bcrypt('12345678')
        ]);
        $sales_user->assignRole('sales-user');

        $sales_admin = User::create([
            'name'=>'adi admin',
            'email'=> 'adi@admin.com',
            'password'=> bcrypt('12345678')
        ]);
        $sales_admin->assignRole('sales-admin-1');
    }
}
