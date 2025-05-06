<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание бронирования - Компьютерный клуб</title>
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
                    <h2>Создание бронирования</h2>
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
                    <form action="{{ route('admin.bookings.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="user_id">Пользователь</label>
                            <select id="user_id" name="user_id" class="form-control" required>
                                <option value="">Выберите пользователя</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="tariff_id">Тариф</label>
                            <select id="tariff_id" name="tariff_id" class="form-control" required>
                                <option value="">Выберите тариф</option>
                                @foreach($tariffs as $tariff)
                                    <option value="{{ $tariff->id }}">
                                        {{ $tariff->name }} ({{ $tariff->price_per_hour }} руб/час, {{ $tariff->is_room ? 'Комната' : 'Общий зал' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="hours">Количество часов</label>
                            <input type="number" id="hours" name="hours" class="form-control" min="1" max="24" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="people">Количество человек</label>
                            <input type="number" id="people" name="people" class="form-control" min="1" max="{{ $maxPeople ?? 5 }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="comment">Комментарий</label>
                            <textarea id="comment" name="comment" class="form-control" rows="3">{{ old('comment') }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="status">Статус</label>
                            <select id="status" name="status" class="form-control" required>
                                <option value="active">Активно</option>
                                <option value="completed">Завершено</option>
                                <option value="cancelled">Отменено</option>
                            </select>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i> Создать бронирование
                            </button>
                            <a href="{{ route('admin.bookings') }}" class="btn-secondary">
                                <i class="fas fa-times"></i> Отмена
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    
</body>
</html>
