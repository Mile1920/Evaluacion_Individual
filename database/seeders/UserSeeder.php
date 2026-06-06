<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@farmabol.com',
            'password' => Hash::make('password'),
            'rol' => 'ADMIN',
        ]);

        User::create([
            'name' => 'Vendedor Uno',
            'email' => 'vendedor@farmabol.com',
            'password' => Hash::make('password'),
            'rol' => 'VENDEDOR',
        ]);
    }
}
