<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Booking;

class ProfileController extends Controller
{
    // Личный кабинет
    public function index()
    {
        $user = Auth::user();

        // Статистика на вкладке Обзор
        $totalBookings = Booking::where('user_id', $user->id)->count();
        $totalHours = Booking::where('user_id', $user->id)->sum('hours');

        // Бронирования для вкладки История
        $bookings = Booking::where('user_id', $user->id)
            ->with(['tariff', 'workstations'])
            ->orderBy('created_at', 'desc')
            ->paginate(3);


        return view('profile.profile', compact('user', 'totalBookings', 'totalHours', 'bookings'));
    }

    // Обновление информации пользователя
    public function update(ProfileUpdateRequest $request)
    {
        $user = Auth::user();
        
        // Получаем валидированные данные
        $validated = $request->validated();
        
        // Обновляем основную информацию
        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        
        // Обновляем пароль, если он был предоставлен
        if ($request->filled('new_password')) {
            $user->password = Hash::make($validated['new_password']);
        }
        
        $user->save();

        return back()->with('status', 'Личная информация успешно обновлена.');
    }

    // Изменение пароля
    public function updatePassword(ProfileUpdateRequest $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($validated['password']);
        $user->save();

        return back()->with('status', 'Пароль успешно изменен');
    }
}
