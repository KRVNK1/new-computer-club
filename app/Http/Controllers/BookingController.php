<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Tariff;
use App\Models\Workstation;

class BookingController extends Controller
{
    // Страница бронирования
    public function show($tariffId)
    {
        $tariff = Tariff::findOrFail($tariffId);

        // Доступные рабочие мест для выбранного тарифа
        if ($tariff->is_room) {
            $availableSpots =  Workstation::where('type', 'VIP')
                ->where('status', 'Свободно')
                ->count(); // Для VIP комнаты - либо доступна, либо нет
        } else {
            $availableSpots = Workstation::where('type', $tariff->name)
                ->where('status', 'Свободно')
                ->count();
        }

        // Количество доступных мест
        $maxPeople = $tariff->is_room ? 5 : $availableSpots;

        return view('booking.show', compact('tariff', 'availableSpots', 'maxPeople'));
    }

    // Сохранение бронирования
    public function store(Request $request, $tariffId)
    {
        $validated = $request->validate([
            'hours' => 'required|integer|min:1|max:24',
            'people' => 'required|integer|min:1',
            'comment' => 'nullable|string|max:100',
        ], [
            'comment.max' => 'Комментарий не должен превышать 100 символов.',
        ]);

        $tariff = Tariff::findOrFail($tariffId);
        $hours = $validated['hours'];
        $people = $validated['people'];

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
                ->take($people)
                ->get();

            if ($workstations->count() < $people) {
                return back()->with('error', 'Недостаточно свободных мест');
            }

            $totalPrice = $tariff->price_per_hour * $hours * $people;
        }

        // Проверка на маты
        $comment = $validated['comment'] ?? '';
        $showComment = $comment;

        if ($comment) {
            $originalComment = $comment;
            $showComment = app('profanityFilter')->filter($comment);

            // Если комментарий изменился после фильтрации, значит был мат
            if ($originalComment !== $showComment) {
                return back()->withErrors(['comment' => 'Комментарий содержит недопустимые слова. Пожалуйста, измените текст.']);
            }
        }

        // Создание бронирования
        $booking = new Booking();
        $booking->user_id = Auth::id();
        $booking->tariff_id = $tariff->id;
        $booking->hours = $hours;
        $booking->people = $people;
        $booking->comment = $showComment;
        $booking->total_price = $totalPrice;
        $booking->save();

        // Обновление статуса рабочих мест
        foreach ($workstations as $workstation) {
            $workstation->status = 'Занято';
            $workstation->save();
            $booking->workstations()->attach($workstation->id);
        }

        return redirect()->route('booking.confirmation', $booking->id)->with('success', 'Бронирование успешно создано!');
    }

    // Страница подтверждения
    public function confirmation($bookingId)
    {
        $booking = Booking::with(['tariff', 'workstations', 'user'])->findOrFail($bookingId);
        $hours = $booking->hours;
        // Проверка, принадлежит ли бронирование текущему пользователю
        if ($booking->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('booking.confirmation', compact('booking', 'hours'));
    }
}
