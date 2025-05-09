<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class DashboardController extends Controller
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
}
