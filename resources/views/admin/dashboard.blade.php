<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель - Компьютерный клуб</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>
    <div class="admin-container">
        <!-- Боковое меню -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1>COMPUTER CLUB</h1>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('admin.users') }}" class="nav-item {{ $activeTab === 'users' ? 'active' : '' }}">
                    <i class="icon-user">
                        <img src="{{ asset('img/admin/Users.svg') }}" alt="Пользователи">
                    </i>
                    <span>ПОЛЬЗОВАТЕЛИ</span>
                </a>

                <a href="{{ route('admin.tariffs') }}" class="nav-item {{ $activeTab === 'tariffs' ? 'active' : '' }}">
                    <i class="icon-tariffs">
                        <img src="{{ asset('img/admin/Tariffs.svg') }}" alt="Тарифы">
                    </i>
                    <span>ТАРИФЫ</span>
                </a>

                <a href="{{ route('admin.workstations') }}" class="nav-item {{ $activeTab === 'workstations' ? 'active' : '' }}">
                    <i class="icon-tariffs">
                        <img src="{{ asset('img/admin/WorkStations.svg') }}" alt="Рабочие места">
                    </i>
                    <span>РАБОЧИЕ МЕСТА</span>
                </a>

                <a href="{{ route('admin.bookings') }}" class="nav-item {{ $activeTab === 'bookings' ? 'active' : '' }}">
                    <i class="icon-booking">
                        <img src="{{ asset('img/admin/Booking.svg') }}" alt="Бронирование">
                    </i>
                    <span>БРОНИРОВАНИЯ</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <a href="{{ route('index') }}" class="nav-item">
                    <i class="icon-home">
                        <img src="{{ asset('img/admin/Home.svg') }}" alt="Бронирование">
                    </i>
                    <span>На сайт</span>
                </a>

                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-item">
                    <i class="icon-logout">
                        <img src="{{ asset('img/admin/Logout.svg') }}" alt="Бронирование">
                    </i>
                    <span>Выход</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </aside>

        <!-- Основной контент -->
        <main class="main-content">
            <header class="admin-header">
                <div class="header-title">
                    <h2>
                        @if($activeTab === 'users')
                        Управление пользователями
                        @elseif($activeTab === 'tariffs')
                        Управление тарифами
                        @elseif($activeTab === 'workstations')
                        Управление рабочими местами
                        @elseif($activeTab === 'bookings')
                        Управление бронированиями
                        @endif
                    </h2>
                </div>

                <div class="header-user">
                    <span class="user-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                </div>
            </header>

            <div class="content-wrapper">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                <!-- Содержимое вкладки пользователей -->
                @if($activeTab === 'users')
                <div class="tab-content active">
                    <div class="content-header">
                        <h3>Список пользователей</h3>
                        <a href="{{ route('admin.users.create') }}" class="btn-primary">
                            <i class="fas fa-plus"></i> Добавить пользователя
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Имя</th>
                                    <th>Фамилия</th>
                                    <th>Email</th>
                                    <th>Телефон</th>
                                    <th>Роль</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $index => $user)
                                <tr>
                                    <td>{{ $users->firstItem() + $index }}</td>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td class="actions">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-icon">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon btn-delete" onclick="return confirm('Вы уверены?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-container">
                        {{ $users->links() }}
                    </div>
                </div>
                @endif

                <!-- Содержимое вкладки тарифов -->
                @if($activeTab === 'tariffs')
                <div class="tab-content active">
                    <div class="content-header">
                        <h3>Список тарифов</h3>
                        <a href="{{ route('admin.tariffs.create') }}" class="btn-primary">
                            <i class="fas fa-plus"></i> Добавить тариф
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Название</th>
                                    <th>Цена за час</th>
                                    <th>Тип</th>
                                    <th>Изображение</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tariffs as $index => $tariff)
                                <tr>
                                    <td>{{ $tariffs->firstItem() + $index }}</td>
                                    <td>{{ $tariff->name }}</td>
                                    <td>{{ $tariff->price_per_hour }} руб.</td>
                                    <td>{{ $tariff->is_room ? 'Комната' : 'Общий зал' }}</td>
                                    <td>
                                        <img src="{{ asset($tariff->image) }}" alt="{{ $tariff->name }}" class="table-image">
                                    </td>
                                    <td class="actions">
                                        <a href="{{ route('admin.tariffs.edit', $tariff->id) }}" class="btn-icon">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.tariffs.delete', $tariff->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon btn-delete" onclick="return confirm('Вы уверены?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-container">
                        {{ $tariffs->links() }}
                    </div>
                </div>
                @endif

                <!-- Содержимое вкладки рабочих мест -->
                @if($activeTab === 'workstations')
                <div class="tab-content active">
                    <div class="content-header">
                        <h3>Список рабочих мест</h3>
                        <a href="{{ route('admin.workstations.create') }}" class="btn-primary">
                            <i class="fas fa-plus"></i> Добавить рабочее место
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Номер</th>
                                    <th>Тип</th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($workstations as $index => $workstation)
                                <tr>
                                    <td>{{ $workstations->firstItem() + $index }}</td>
                                    <td>{{ $workstation->number }}</td>
                                    <td>{{ $workstation->type }}</td>
                                    <td>
                                        {{ $workstation->status }}
                                    </td>
                                    </td>
                                    <td class="actions">
                                        <a href="{{ route('admin.workstations.edit', $workstation->id) }}" class="btn-icon">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.workstations.delete', $workstation->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon btn-delete" onclick="return confirm('Вы уверены?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination">
                        {{ $workstations->links() }}
                    </div>
                </div>
                @endif

                <!-- Содержимое вкладки бронирований -->
                @if($activeTab === 'bookings')
                <div class="tab-content active">
                    <div class="content-header">
                        <h3>Список бронирований</h3>
                        <a href="{{ route('admin.bookings.create') }}" class="btn-primary">
                            <i class="fas fa-plus"></i> Добавить бронирование
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Пользователь</th>
                                    <th>Тариф</th>
                                    <th>Часы</th>
                                    <th>Человек</th>
                                    <th>Стоимость</th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $index => $booking)
                                <tr>
                                    <td>{{ $bookings->firstItem() + $index }}</td>
                                    <td>{{ $booking->user->first_name }} {{ $booking->user->last_name }}</td>
                                    <td>{{ $booking->tariff->name }}</td>
                                    <td>{{ $booking->hours }}</td>
                                    <td>{{ $booking->people }}</td>
                                    <td>{{ $booking->total_price }} руб.</td>
                                    <td>
                                        <span class="status-badge status-{{ $booking->status }}">
                                            @switch($booking->status)
                                            @case('active')
                                            Активно
                                            @break
                                            @case('completed')
                                            Завершено
                                            @break
                                            @case('cancelled')
                                            Отменено
                                            @break
                                            @default
                                            {{ $booking->status }}
                                            @endswitch
                                        </span>
                                    </td>
                                    <td class="actions">
                                        <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn-icon">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.bookings.delete', $booking->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon btn-delete" onclick="return confirm('Вы уверены?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-container">
                        {{ $bookings->links() }}
                    </div>
                </div>
                @endif
            </div>
        </main>
    </div>



</body>

</html>