<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Tariff;
use App\Models\Workstation;
use App\Models\User;

class AdminController extends Controller
{
    // Показ админ-панели
    public function index()
    {
        return redirect()->route('admin.users');
    }

    // Список пользователей
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

    // Список тарифов
    public function tariffs()
    {
        $tariffs = Tariff::paginate(6);
        $activeTab = 'tariffs';

        return view('admin.dashboard', compact('tariffs', 'activeTab'));
    }

    // Создание тарифа(представление)
    public function createTariff()
    {
        return view('admin.tariffs.create');
    }

    // Сохранение тарифа
    public function storeTariff(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price_per_hour' => 'required|numeric|min:0',
            'is_room' => 'boolean',
            'image' => 'nullable|image|max:255',
        ]);

        // Создание тарифа
        $tariff = new Tariff();
        $tariff->name = $validated['name'];
        $tariff->price_per_hour = $validated['price_per_hour'];
        $tariff->is_room = $request->has('is_room') ? 1 : 0;

        // Обработка загрузки изображения
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // getClientOriginalExtension - Указание типа файла 
            $image->move(public_path('/img/tariffs'), $imageName); // Перенос картинки в img/tariffs
            $tariff->image = '/img/tariffs/' . $imageName;
        } else {
            $tariff->image = '/img/tariffs/pc2.png'; // если картинка не загружена берется стандартная картинка
        }

        $tariff->save();

        return redirect()->route('admin.tariffs')->with('success', 'Тариф успешно создан');
    }

    // Редактирование тарифа(представление)
    public function editTariff($id)
    {
        $tariff = Tariff::findOrFail($id);
        return view('admin.tariffs.edit', compact('tariff'));
    }

    // Обновление тарифа
    public function updateTariff(Request $request, $id)
    {
        $tariff = Tariff::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price_per_hour' => 'required|numeric|min:0',
            'is_room' => 'boolean',
            'image' => 'nullable|image|max:255',
        ]);

        $tariff->name = $validated['name'];
        $tariff->price_per_hour = $validated['price_per_hour'];
        $tariff->is_room = $request->has('is_room') ? 1 : 0;

        // Обработка загрузки изображения
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/tariffs'), $imageName);
            $tariff->image = 'img/tariffs/' . $imageName;
        }

        $tariff->save();

        return redirect()->route('admin.tariffs')->with('success', 'Данные тарифа обновлены');
    }

    // Удаление тарифа
    public function deleteTariff($id)
    {
        $tariff = Tariff::findOrFail($id);

        $tariff->delete();

        return redirect()->route('admin.tariffs')->with('success', 'Тариф удален');
    }

    // Список рабочих мест
    public function workstations()
    {
        $workstations = Workstation::paginate(6);
        $activeTab = 'workstations';

        return view('admin.dashboard', compact('workstations', 'activeTab'));
    }

    // Создание рабочих мест(представление)
    public function createWorkstation()
    {
        $tariffs = Tariff::all();
        return view('admin.workstations.create', compact('tariffs'));
    }

    // Сохранение рабочего места
    public function storeWorkstation(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:255|unique:workstations',
            'type' => 'required|string|max:255',
            'status' => 'required|in:Свободно,Занято',
        ]);

        $workstation = new Workstation();
        $workstation->number = $validated['number'];
        $workstation->type = $validated['type'];
        $workstation->status = $validated['status'];
        $workstation->save();

        return redirect()->route('admin.workstations')->with('success', 'Рабочее место успешно создано');
    }

    // Редактирование рабочего места
    public function editWorkstation($id)
    {
        $workstation = Workstation::findOrFail($id);
        $tariffs = Tariff::all();
        return view('admin.workstations.edit', compact('workstation', 'tariffs'));
    }

    // Обновление рабочего места
    public function updateWorkstation(Request $request, $id)
    {
        $workstation = Workstation::findOrFail($id);

        $validated = $request->validate([
            'number' => 'required|string|max:255|unique:workstations,number,' . $id,
            'type' => 'required|string|max:255',
            'status' => 'required|in:Свободно,Занято',
        ]);

        $workstation->number = $validated['number'];
        $workstation->type = $validated['type'];
        $workstation->status = $validated['status'];
        $workstation->save();

        return redirect()->route('admin.workstations')->with('success', 'Данные рабочего места обновлены');
    }

    // Удаление рабочего места
    public function deleteWorkstation($id)
    {
        $workstation = Workstation::findOrFail($id);
        $workstation->delete();

        return redirect()->route('admin.workstations')->with('success', 'Рабочее место удалено');
    }

    // Список бронирований
    public function bookings(Request $request)
    {
        $query = Booking::with(['user', 'tariff']);
        $search = null;

        if ($request->has('search')) {
            $search = $request->input('search'); // Standart
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
