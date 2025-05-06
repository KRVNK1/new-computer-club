<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tariff;

class TariffSeeder extends Seeder
{
    // Создание тарифов
    public function run(): void
    {
        Tariff::create([
            'name' => 'Standart',
            'price_per_hour' => 120, // 2880 руб / 24 часа
            'is_room' => false,
            'image' => '/img/tariffs/pc1.png',
        ]);

        Tariff::create([
            'name' => 'VIP',
            'price_per_hour' => 800, // 160 * 5 = цена за всю комнату
            'is_room' => true,
            'image' => '/img/tariffs/pc3.png',
        ]);
        
    }
}
