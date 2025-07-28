<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'login' => 'admin',
            'email' => 'admin@odontosys.teste',
            'password' => Hash::make('adminodonto'),
            'tipo' => 'Admin',
        ]);
    }
}