<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'RoSys Admin',
            'email' => 'admin@rosys.com',
            'phone' => '0123456789',
            'address' => 'RoSys Shop',
            'role' => 'admin',
            'password' => Hash::make('Admin@12345'),
        ]);
    }
}