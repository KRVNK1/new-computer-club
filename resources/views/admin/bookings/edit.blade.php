<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование бронирования - Компьютерный клуб</title>
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
                <a href="{{ route('admin.users') }}" class="nav-item">
                    <i class="icon-user">
                        <img src="{{ asset('img/admin/Users.svg') }}" alt="Пользователи">
                    </i>
                    <span>ПОЛЬЗОВАТЕЛИ</span>
                </a>

                <a href="{{ route('admin.tariffs') }}" class="nav-item">
                    <i class="icon-tariffs">
                        <img src="{{ asset('img/admin/Tariffs.svg') }}" alt="Тарифы">
                    </i>
                    <span>ТАРИФЫ</span>
                </a>

                <a href="{{ route('admin.workstations') }}" class="nav-item">
                    <i class="icon-tariffs">
                        <img src="{{ asset('img/admin/WorkStations.svg') }}" alt="Рабочие места">
                    </i>
                    <span>РАБОЧИЕ МЕСТА</span>
                </a>

                <a href="{{ route('admin.bookings') }}" class="nav-item active">
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
                    <h2>Редактирование бронирования</h2>
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

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="form-container">
                    <div class="info-section">
                        <h3>Информация о бронировании</h3>

                        <div class="info-grid">
                            <div class="info-item">
                                <label>Тариф:</label>
                                <span class="info-value">
                                    {{ $booking->tariff->name }}
                                    ({{ $booking->tariff->price_per_hour }} руб/час,
                                    {{ $booking->tariff->is_room ? 'Комната' : 'Общий зал' }})
                                </span>
                            </div>

                            <div class="info-item">
                                <label>Количество человек:</label>
                                <span class="info-value">{{ $booking->people }}</span>
                            </div>

                            <div class="info-item">
                                <label>Комментарий:</label>
                                <span class="info-value">{{ $booking->comment ?: 'Не указан' }}</span>
                            </div>

                            <div class="info-item">
                                <label>Текущая стоимость:</label>
                                <span class="info-value price">{{ $booking->total_price }} руб</span>
                            </div>
                        </div>

                        <!-- Рабочие места -->
                        <div class="workstations-info">
                            <label>Назначенные рабочие места:</label>
                            @if($booking->workstations->count() > 0)
                            <div class="workstations-list">
                                @foreach($booking->workstations as $workstation)
                                <span class="workstation-badge">
                                    №{{ $workstation->number }} ({{ $workstation->type }})
                                </span>
                                @endforeach
                            </div>
                            @else
                            <span class="info-value text-muted">Нет назначенных рабочих мест</span>
                            @endif
                        </div>
                    </div>

                    <div class="edit-section">
                        <h3>Редактируемые поля</h3>

                        <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="user_id">Пользователь <span class="required">*</span></label>
                                <select id="user_id" name="user_id" class="form-control" required>
                                    <option value="">Выберите пользователя</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $booking->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="hours">Количество часов</label>
                                <input type="number" id="hours" name="hours" class="form-control" value="{{ old('hours', $booking->hours) }}" min="1" max="24" required>
                            </div>

                            <div class="form-group">
                                <label for="status">Статус</label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="active" {{ $booking->status == 'active' ? 'selected' : '' }}>
                                        Активно
                                    </option>
                                    <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>
                                        Завершено
                                    </option>
                                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>
                                        Отменено
                                    </option>
                                </select>
                             
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn-primary">
                                    Сохранить изменения
                                </button>
                                <a href="{{ route('admin.bookings') }}" class="btn-secondary">
                                    Отмена
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style></style>

</body>

</html>