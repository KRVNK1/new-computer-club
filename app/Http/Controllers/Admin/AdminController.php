<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Models\Workstation;

abstract class AdminController
{
    // Показ админ-панели
    public function index()
    {
        return redirect()->route('admin.users');
    }
    
    // Освобождение рабочего места
    public function releaseWorkstations(Booking $booking)
    {
        foreach ($booking->workstations as $workstation) {
            $workstation->status = 'Свободно';
            $workstation->save();
        }
    }

    // Назначение рабочих мест для бронирования
    public function assignWorkstations(Booking $booking)
    {
        $tariff = $booking->tariff;

        // Очищаем текущие связи с рабочими местами
        $booking->workstations()->detach();

        if ($tariff->is_room) {
            // Для VIP комнаты
            $workstations = Workstation::where('type', $tariff->name)
                ->where('status', 'Свободно')
                ->take(5)
                ->get();

            if ($workstations->count() < 5) {
                return redirect()->back()->with('error', 'Недостаточно свободных мест для VIP-комнаты');
            }
        } else {
            // Для общего зала
            $workstations = Workstation::where('type', $tariff->name)
                ->where('status', 'Свободно')
                ->take($booking->people)
                ->get();

            if ($workstations->count() < $booking->people) {
                return redirect()->back()->with('error', 'Недостаточно свободных мест');
            }
        }

        // Занимаем рабочие места
        foreach ($workstations as $workstation) {
            $workstation->status = 'Занято';
            $workstation->save();
            $booking->workstations()->attach($workstation->id);
        }
    }
}
