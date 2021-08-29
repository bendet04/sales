<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleSales = Role::create([
            'name'=>'sales',
            'guard_name'=>'web'
        ]);
        $roleSales->givePermissionTo('sales');

        $roleAdmin1 = Role::create([
            'name'=>'admin-1',
            'guard_name'=>'web'
        ]);
        $roleAdmin1->givePermissionTo('admin lvl 1');

        $roleAdmin2 = Role::create([
            'name'=>'admin-2',
            'guard_name'=>'web'
        ]);
        $roleAdmin2->givePermissionTo('admin lvl 2');

        $roleTechnician = Role::create([
            'name'=>'technician',
            'guard_name'=>'web'
        ]);
        $roleTechnician->givePermissionTo('technician');
    }
}
