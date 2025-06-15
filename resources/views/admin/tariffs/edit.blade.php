<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование тарифа - Компьютерный клуб</title>
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

                <a href="{{ route('admin.tariffs') }}" class="nav-item active">
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

                <a href="{{ route('admin.bookings') }}" class="nav-item">
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
                    <h2>Редактирование тарифа</h2>
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
                    <form action="{{ route('admin.tariffs.update', $tariff->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Название</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $tariff->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="price_per_hour">Цена за час</label>
                            <input type="number" id="price_per_hour" name="price_per_hour" class="form-control" value="{{ old('price_per_hour', $tariff->price_per_hour) }}" step="0.01" min="0" required>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" id="is_room" name="is_room" class="form-check-input" value="1" {{ old('is_room', $tariff->is_room) ? 'checked' : '' }}>
                                <label for="is_room" class="form-check-label">VIP-комната (если не отмечено, то общий зал)</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="image">Изображение</label>
                            @if($tariff->image)
                            <div class="current-image">
                                <img src="{{ asset($tariff->image) }}" alt="{{ $tariff->name }}" style="max-width: 200px; margin-bottom: 10px;">
                            </div>
                            @endif
                            <input type="file" id="image" name="image" class="form-control">
                            <span class="help-text">Оставьте пустым, если не хотите менять изображение</span>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-primary">
                                Сохранить изменения
                            </button>
                            <a href="{{ route('admin.tariffs') }}" class="btn-secondary">
                                Отмена
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

</body>

</html>