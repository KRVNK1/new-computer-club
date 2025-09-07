<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends AdminController
{
    public function users(Request $request)
    {
        $query = User::query();
        $search = null;

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($qb) use ($search) {
                $qb->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(6)->appends(request()->query());

        $activeTab = 'users';

        return view('admin.dashboard', compact('users', 'activeTab'));
    }

    // Создание пользователя(представление)
    public function createUser()
    {
        return view('admin.users.create');
    }

    // Сохранение пользователя
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:45',
            'last_name' => 'required|string|max:45',
            'login' => 'required|string|max:45',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users',
            'phone' => 'required|string|min:11|max:11',
            'role' => 'required|in:client,admin',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Создание пользователя
        $user = new User();
        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->login = $validated['login'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->role = $validated['role'];
        $user->password = $validated['password'];
        $user->save();

        return redirect()->route('admin.users')->with('success', 'Пользователь успешно создан');
    }

    // Редактирования пользователя
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $isCurrentUser = Auth::id() == $user->id;
        return view('admin.users.edit', compact('user', 'isCurrentUser'));
    }

    // Обновление данных пользователя
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:45',
            'last_name' => 'required|string|max:45',
            'login' => 'required|string|max:45',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users,email,' . $id,
            'phone' => 'required|string|max:11|min:11',
            'role' => 'required|in:client,admin',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->login = $validated['login'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->role = $validated['role'];

        // Если пароль указан, то создается новый пароль
        if ($validated['password']) {
            $user->password = $validated['password'];
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'Данные пользователя обновлены');
    }

    // Удаление пользователя
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() === $user->id) {
            return redirect()->route('admin.users')->with('error', 'Вы не можете удалить свой собственный аккаунт');
        }

        $activeBookings = Booking::where('user_id', $id)
            ->where('status', 'active')
            ->with('workstations')
            ->get(); 

        // Освобождаем рабочие места для каждого активного бронирования
        foreach ($activeBookings as $booking) {
            $this->releaseWorkstations($booking);
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Пользователь удален');
    }
}
