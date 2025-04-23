<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tariff;

class TariffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tariff::create([
            'name' => 'Standart',
            'price_per_hour' => 120, // 2880 руб / 24 часа
            'is_room' => false,
            'image' => '/img/tariffs/pc1.png',
            'description' => 'Стандартная конфигурация для игр и работы'
        ]);

        Tariff::create([
            'name' => 'VIP',
            'price_per_hour' => 800, // 160 * 5 = цена за всю комнату
            'is_room' => true,
            'image' => '/img/tariffs/pc3.png',
            'description' => 'Максимальная производительность и комфорт'
        ]);
        
    }
}
