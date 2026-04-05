<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nom_user'       => 'Admin Vibes',
            'edad_user'      => 25,
            'email_user'     => env('ADMIN_EMAIL'),
            'contra_user'    => Hash::make(env('ADMIN_PASSWORD')),
            'role'           => 'admin',
            'registro_user'  => 'activo',
            'email_verified' => true,
        ]);
    }
}
