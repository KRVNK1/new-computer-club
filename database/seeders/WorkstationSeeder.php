<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WorkStation;

class WorkstationSeeder extends Seeder
{
    public function run()
    {
        // Создаем 5 станций типа Standart
        for ($i = 1; $i <= 5; $i++) {
            Workstation::create([
                'number' => $i,
                'status' => 'Свободно',
                'type' => 'Standart'
            ]);
        }
        
        // Создаем 3 станции типа BootCamp
        for ($i = 6; $i <= 8; $i++) {
            Workstation::create([
                'number' => $i,
                'status' => 'Свободно',
                'type' => 'BootCamp'
            ]);
        }
        
        // Создаем 2 станции типа VIP
        for ($i = 9; $i <= 10; $i++) {
            Workstation::create([
                'number' => $i,
                'status' => 'Свободно',
                'type' => 'VIP'
            ]);
        }
    }
}
