<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */    public function run()
    {
        Role::create([
            'name' => 'Admin',
            'description' => 'Administrator with full access'
        ]);

        Role::create([
            'name' => 'Customer',
            'description' => 'Customer with limited access'
        ]);

        Role::create([
            'name' => 'HelpDesk',
            'description' => 'Help-Desk with limited access'
        ]);

            Role::create([
            'name' => 'Technician',
            'description' => 'Technician with limited access'
        ]);
    }
}
