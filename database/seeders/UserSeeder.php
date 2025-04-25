<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Никита',
            'last_name' => 'Курашов',
            'login' => 'KRVNK',
            'email' => 'admin@bk.ru',
            'password' => '12345678',
            'phone' => '89085553535',
            'role' => 'admin'
        ]);
    }
}
