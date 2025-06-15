<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание рабочего места - Компьютерный клуб</title>
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

                <a href="{{ route('admin.workstations') }}" class="nav-item active">
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
                    <h2>Создание рабочего места</h2>
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
                    <form action="{{ route('admin.workstations.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="number">Номер</label>
                            <input type="text" id="number" name="number" class="form-control" value="{{ old('number') }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="type">Тип</label>
                            <select name="type" id="type" class="form-control">
                                @foreach ($tariffs as $tariff)
                                <option value="{{ $tariff->name }}">{{ $tariff->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <input type="hidden" id="status" name="status" value="Свободно">
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn-primary">
                                Создать рабочее место
                            </button>
                            <a href="{{ route('admin.workstations') }}" class="btn-secondary">
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
