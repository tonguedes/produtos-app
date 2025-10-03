<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@meusite.com'], // Evita duplicação
            [
                'name' => 'Administrador',
                'password' => Hash::make('12345678'), // Troque para uma senha segura
                'is_admin' => true, // Certifique-se que a coluna existe no users
            ]
        );
    }
}
