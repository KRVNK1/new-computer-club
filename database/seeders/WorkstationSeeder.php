<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WorkStation;

class WorkstationSeeder extends Seeder
{
    // Создание рабочих мест
    public function run()
    {
        // Создаем 10 рабочих мест типа Standart
        for ($i = 1; $i <= 10; $i++) {
            Workstation::create([
                'number' => $i,
                'status' => 'Свободно',
                'type' => 'Standart'
            ]);
        }
           
        // Создаем 5 рабочих мест типа VIP
        for ($i = 11; $i <= 15; $i++) {
            Workstation::create([
                'number' => $i,
                'status' => 'Свободно',
                'type' => 'VIP'
            ]);
        }
    }
}
