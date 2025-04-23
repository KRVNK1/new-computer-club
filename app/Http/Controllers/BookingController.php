<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Booking;
use App\Models\Tariff;
use App\Models\Workstation;

class BookingController extends Controller
{
    public function show($tariffId)
    {
        $tariff = Tariff::findOrFail($tariffId);

        $tariffs = Tariff::all();

        // Получаем доступные рабочие станции для выбранного типа тарифа
        if ($tariff->is_room) {
            $availableSpots = 5; // Для VIP комнаты - либо доступна, либо нет
        } else {
            $availableSpots = Workstation::where('type', $tariff->name)
                ->where('status', 'Свободно')
                ->count();
        }

        // Количество доступных мест
        $maxPeople = $tariff->is_room ? 5 : $availableSpots;

        return view('booking.show', compact('tariff', 'tariffs', 'availableSpots', 'maxPeople'));
    }

    public function store(Request $request, $tariffId)
    {
        $validated = $request->validate([
            'hours' => 'required|integer|min:1|max:24',
            'people' => 'required|integer|min:1',
            'comment' => 'nullable|string',
        ]);

        $tariff = Tariff::findOrFail($tariffId);
        $hours = $validated['hours'];

        // нахождение рабочего места по типу(тариф) и статусу
        if ($tariff->is_room) {
            // Для VIP комнаты
            $workstations = Workstation::where('type', $tariff->name)
                ->where('status', 'Свободно')
                ->take(5)
                ->get();

            if ($workstations->count() < 5) {
                return back()->with('error', 'VIP-комната уже занята');
            }

            $totalPrice = $tariff->price_per_hour * $hours;
        } else {
            // Для общего зала
            $workstations = Workstation::where('type', $tariff->name)
                ->where('status', 'Свободно')
                ->take($validated['people'])
                ->get();

            if ($workstations->count() < $validated['people']) {
                return back()->with('error', 'Недостаточно свободных мест');
            }

            $totalPrice = $tariff->price_per_hour * $hours * $validated['people'];
        }

        // Создание бронирования
        $booking = new Booking();
        $booking->user_id = Auth::id();
        $booking->tariff_id = $tariff->id;
        $booking->hours = $validated['hours'];
        $booking->people = $validated['people'];
        $booking->comment = $validated['comment'] ?? '';
        $booking->total_price = $totalPrice;
        $booking->save();

        // Обновляем статус рабочих мест
        foreach ($workstations as $workstation) {
            $workstation->status = 'Занято';
            $workstation->save();
            $booking->workstations()->attach($workstation->id);
        }

        return redirect()->route('booking.confirmation', $booking->id)
            ->with('success', 'Бронирование успешно создано!');
    }

    public function confirmation($bookingId)
    {
        $booking = Booking::with(['tariff', 'workstations', 'user'])->findOrFail($bookingId);
        $hours = $booking->hours;
        // Проверка, принадлежит ли бронирование текущему пользователю
        if ($booking->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('booking.confirmation', compact('booking', 'hours'));
    }



    // public function checkAvailability(Request $request)
    // {
    //     $tariffId = $request->tariff_id;
    //     $people = $request->people;

    //     $tariff = Tariff::findOrFail($tariffId);

    //     if ($tariff->is_room) {
    //         $available = Workstation::where('type', $tariff->name)
    //             ->where('status', 'Свободно')
    //             ->count() >= 5;

    //         return response()->json([
    //             'available' => $available,
    //             'message' => $available ? 'VIP-комната доступна' : 'VIP-комната занята'
    //         ]);
    //     } else {
    //         $availableCount = Workstation::where('type', $tariff->name)
    //             ->where('status', 'Свободно')
    //             ->count();

    //         $available = $availableCount >= $people;

    //         return response()->json([
    //             'available' => $available,
    //             'availableCount' => $availableCount,
    //             'message' => $available ? "Доступно мест: $availableCount" : "Недостаточно мест. Доступно: $availableCount"
    //         ]);
    //     }
    // }
}
