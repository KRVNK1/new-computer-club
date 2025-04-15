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
            'first_name' => '123',
            'login' => '123',
            'email' => 'admin@bk.ru',
            'password' => '12345678',
            'role' => 'client'
        ]);
    }
}
