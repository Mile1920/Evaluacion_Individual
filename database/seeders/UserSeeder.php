<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Administrador',
            'email'    => 'admin@farmabol.com',
            'password' => Hash::make('password'),
            'rol'      => 'ADMIN',
        ]);

        User::create([
            'name'     => 'Vendedor Uno',
            'email'    => 'vendedor@farmabol.com',
            'password' => Hash::make('password'),
            'rol'      => 'VENDEDOR',
        ]);
    }
}