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
        $workstations = Workstation::where('type', $tariff->name)
            ->where('status', 'Свободно')
            ->get();

        // Количество доступных мест
        $availableSpots = $workstations->count();

        return view('booking.show', compact('tariff', 'tariffs', 'availableSpots'));
    }

    public function store(Request $request, $tariffId)
    {
        $validated = $request->validate([
            'hours' => 'required|integer|min:1|max:72',
            'people' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $tariff = Tariff::findOrFail($tariffId);

        // нахождение рабочего места по типу(тариф) и статусу
        $workstation = Workstation::where('type', $tariff->name)
            ->where('status', 'Свободно')
            ->first();

        if (!$workstation) {
            return back()->with('error', 'К сожалению, все места данного типа заняты.');
        }

        // Расчет стоимости
        $totalPrice = $tariff->price_per_hour * $validated['hours'] * $validated['people'];

        // Создание бронирования
        $booking = new Booking();
        $booking->user_id = Auth::id();
        $booking->workstation_id = $workstation->id;
        $booking->tariff_id = $tariff->id;
        $booking->hours = $validated['hours'];
        $booking->people = $validated['people'];
        $booking->comment = $validated['comment'] ?? '';
        $booking->total_price = $totalPrice;
        $booking->save();

        // Обновляем статус рабочей станции
        $workstation->status = 'Занято';
        $workstation->save();

        return redirect()->route('booking.confirmation', $booking->id)
            ->with('success', 'Бронирование успешно создано!');
    }

    public function confirmation($bookingId)
    {
        $booking = Booking::with(['tariff', 'workstation', 'user'])->findOrFail($bookingId);

        // Проверка, принадлежит ли бронирование текущему пользователю
        if ($booking->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('booking.confirmation', compact('booking'));
    }
}
