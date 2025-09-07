<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Models\Tariff;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends AdminController
{
    // Список бронирований
    public function bookings(Request $request)
    {
        $query = Booking::with(['user', 'tariff']);
        $search = null;

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($qb) use ($search) {
                $qb->where('total_price', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('tariff', function ($tariffQuery) use ($search) {
                        $tariffQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $bookings = $query->paginate(6)->appends(request()->query());

        $activeTab = 'bookings';

        return view('admin.dashboard', compact('bookings', 'activeTab'));
    }

    // Создание бронирования
    public function createBooking()
    {
        $users = User::all();
        $tariffs = Tariff::all();

        return view('admin.bookings.create', compact('users', 'tariffs'));
    }

    // Сохранение бронирования
    public function storeBooking(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tariff_id' => 'required|exists:tariffs,id',
            'hours' => 'required|integer|min:1|max:24',
            'people' => 'required|integer|min:1',
            'comment' => 'nullable|string',
            'status' => 'required|in:active,completed,cancelled',
        ]);

        $tariff = Tariff::findOrFail($validated['tariff_id']);

        // Расчет общей стоимости
        if ($tariff->is_room) {
            $totalPrice = $tariff->price_per_hour * $validated['hours'];
        } else {
            $totalPrice = $tariff->price_per_hour * $validated['hours'] * $validated['people'];
        }

        // Создание бронирования
        $booking = new Booking();
        $booking->user_id = $validated['user_id'];
        $booking->tariff_id = $validated['tariff_id'];
        $booking->hours = $validated['hours'];
        $booking->people = $validated['people'];
        $booking->comment = $validated['comment'] ?? '';
        $booking->total_price = $totalPrice;
        $booking->status = $validated['status'];
        $booking->save();

        // Если статус активный, занимаем рабочие места
        if ($booking->status === 'active') {
            $this->assignWorkstations($booking);
        }

        return redirect()->route('admin.bookings')->with('success', 'Бронирование успешно создано');
    }

    // Редактирование бронирования
    public function editBooking($id)
    {
        $booking = Booking::with(['user', 'tariff', 'workstations'])->findOrFail($id);
        $users = User::all();
        $tariffs = Tariff::all();
        return view('admin.bookings.edit', compact('booking', 'users', 'tariffs'));
    }

    // Обновление бронирования
    public function updateBooking(Request $request, $id)
    {
        $booking = Booking::with(['workstations', 'tariff'])->findOrFail($id);

        // Валидация только редактируемых полей
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'hours' => 'required|integer|min:1|max:24',
            'status' => 'required|in:active,completed,cancelled',
        ]);

        $oldStatus = $booking->status;
        $newStatus = $validated['status'];

        $newHours = $validated['hours'];

        // Пересчет стоимости при изменении часов
        $tariff = $booking->tariff;
        if ($tariff->is_room) {
            $totalPrice = $tariff->price_per_hour * $newHours;
        } else {
            $totalPrice = $tariff->price_per_hour * $newHours * $booking->people;
        }

        // Обновляем только редактируемые поля
        $booking->user_id = $validated['user_id'];
        $booking->hours = $newHours;
        $booking->total_price = $totalPrice;
        $booking->status = $newStatus;
        $booking->save();

        // Обработка изменения статуса
        if ($oldStatus !== $newStatus) {
            // Если новый статус "completed" или "cancelled", освобождаем рабочие места
            if ($newStatus == 'completed' || $newStatus == 'cancelled') {
                $this->releaseWorkstations($booking);
            }
            // Если новый статус "active", а старый был не активным, занимаем рабочие места
            elseif ($newStatus === 'active' && $oldStatus !== 'active') {
                $this->assignWorkstations($booking);
            }
        }

        return redirect()->route('admin.bookings')->with('success', 'Данные бронирования обновлены');
    }

    // Удаление бронирования
    public function deleteBooking($id)
    {
        $booking = Booking::with('workstations')->findOrFail($id);

        // Если бронирование активно, освобождаем рабочие места
        if ($booking->status === 'active') {
            $this->releaseWorkstations($booking);
        }

        $booking->delete();

        return redirect()->route('admin.bookings')->with('success', 'Бронирование удалено');
    }
}
