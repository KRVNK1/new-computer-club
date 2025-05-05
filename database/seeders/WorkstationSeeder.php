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
        // Создаем 5 станций типа Standart
        for ($i = 1; $i <= 10; $i++) {
            Workstation::create([
                'number' => $i,
                'status' => 'Свободно',
                'type' => 'Standart'
            ]);
        }
           
        // Создаем 5 станции типа VIP
        for ($i = 11; $i <= 15; $i++) {
            Workstation::create([
                'number' => $i,
                'status' => 'Свободно',
                'type' => 'VIP'
            ]);
        }
    }
}
