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
            'price_per_hour' => 45, // 1080 руб / 24 часа
            'image' => '/img/tariffs/pc1.png',
            'description' => 'Стандартная конфигурация для игр и работы'
        ]);
        
        Tariff::create([
            'name' => 'BootCamp',
            'price_per_hour' => 55, // 1320 руб / 24 часа
            'image' => '/img/tariffs/pc2.png',
            'description' => 'Улучшенная конфигурация для требовательных игр'
        ]);
        
        Tariff::create([
            'name' => 'VIP',
            'price_per_hour' => 85, // 2040 руб / 24 часа
            'image' => '/img/tariffs/pc3.png',
            'description' => 'Максимальная производительность и комфорт'
        ]);

    }
}
