<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'nelvinchola.dev@outlook.com',
            'contact' => '0967660849',
            'address' => 'lusaka west',
            'Nrc' => '522681/68/1',
            'password' => Hash::make('password'),
            'role_id' => 1 // Admin role
        ]);
    }
}