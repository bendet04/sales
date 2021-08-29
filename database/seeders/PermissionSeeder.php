<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'sales', 'guard_name'=>'web']);
        Permission::create(['name' => 'admin lvl 1', 'guard_name'=>'web']);
        Permission::create(['name' => 'admin lvl 2','guard_name'=>'web']);
        Permission::create(['name' => 'technician','guard_name'=>'web']);
    }
}
