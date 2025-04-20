<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет - Cyber Arena</title>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global/media.css') }}">

</head>

<body>
    <div class="main-container">
        <header class="header">
            <img src="{{ asset ('/img/background/background-header.png') }}"
                class="background-image" alt="Background">
            <div class="header-content">
                <a href=" {{ route('index') }} ">
                    <img src="{{ asset ('/img/LOGO.png') }}"
                        class="logo" alt="Cyber Arena Logo">
                </a>

                <nav class="navigation">
                    <a href="#gallery" class="nav-link">Фото</a>
                    <a href="#tariffs" class="nav-link">Тарифы</a>
                    <a href="#specs" class="nav-link">Комплектующие</a>
                    <a href="#map" class="nav-link">Как добраться</a>
                    <a href="{{ route('login') }}" class="login-button">Войти</a>
                </nav>

                <nav class="nav-menu-toggle">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </nav>
            </div>
        </header>

        <section class="dashboard">
            <div class="dashboard-container">
                <div class="dashboard-header">
                    <div class="dashboard-welcome">
                        <h1>Привет, {{ Auth::user()->first_name ?? 'Пользователь' }}!</h1>
                        <p>Добро пожаловать в личный кабинет</p>
                    </div>
                </div>

                <!-- Сообщения об успехе/ошибке -->
                @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Вкладки -->
                <div class="dashboard-tabs">
                    <button class="dashboard-tab active" data-tab="overview">Обзор</button>
                    <button class="dashboard-tab" data-tab="bookings">История бронирований</button>
                    <button class="dashboard-tab" data-tab="profile">Личные данные</button>
                    <button class="dashboard-tab" data-tab="security">Безопасность</button>
                </div>


                <div class="dashboard-content">
                    <!-- Обзор -->
                    <div class="tab-content active" id="overview">
                        <div class="stats-grid">
                            <div class="stat-card">
                                <p class="stat-value">{{ $totalBookings }}</p>
                                <p class="stat-label">Всего бронирований</p>
                            </div>
                            <div class="stat-card">
                                <p class="stat-value">{{ $totalHours }}</p>
                                <p class="stat-label">Часов в клубе</p>
                            </div>
                        </div>

                        <div class="dashboard-cards">
                            <div class="dashboard-card">
                                <h2>
                                    <i class="icon-calendar"></i>
                                    Последние бронирования
                                </h2>

                                <ul class="booking-list">
                                    @forelse($bookings->take(2) as $booking)
                                    <li class="booking-item">
                                        <div class="booking-info">
                                            <h3 class="booking-title">{{ $booking->tariff->name }}</h3>
                                            <div class="booking-meta">
                                                <span>
                                                    <i class="icon-clock"></i>
                                                    {{ $booking->hours }} часов
                                                </span>
                                                <span>
                                                    <i class="icon-users"></i>
                                                    {{ $booking->people }} человек
                                                </span>
                                                <span>
                                                    <i class="icon-calendar"></i>
                                                    {{ $booking->created_at->format('d.m.Y') }}
                                                </span>
                                            </div>
                                        </div>
                                        <span class="booking-status status-{{ $booking->status }}">
                                            @if($booking->status == 'active')
                                            Активно
                                            @elseif($booking->status == 'completed')
                                            Завершено
                                            @elseif($booking->status == 'cancelled')
                                            Отменено
                                            @endif
                                        </span>
                                    </li>
                                    @empty
                                    <li class="booking-item">
                                        <p>У вас пока нет бронирований</p>
                                    </li>
                                    @endforelse
                                </ul>

                                <div class="dashboard-actions">
                                    <button class="btn btn-secondary" onclick="switchTab('bookings')">
                                        <i class="icon-arrow-right"></i>
                                        Все бронирования
                                    </button>
                                </div>
                            </div>

                            <div class="dashboard-card">
                                <h2>
                                    <i class="icon-user"></i>
                                    Личные данные
                                </h2>

                                <ul class="user-info">
                                    <li>
                                        <span class="info-label">Имя:</span>
                                        <span class="info-value">{{ $user->first_name }} {{ $user->last_name }}</span>
                                    </li>
                                    <li>
                                        <span class="info-label">Логин:</span>
                                        <span class="info-value">{{ $user->login }}</span>
                                    </li>
                                    <li>
                                        <span class="info-label">Email:</span>
                                        <span class="info-value">{{ $user->email }}</span>
                                    </li>
                                    <li>
                                        <span class="info-label">Телефон:</span>
                                        <span class="info-value">{{ $user->phone }}</span>
                                    </li>
                                </ul>
                                <!--  -->
                                <div class="dashboard-actions">
                                    
                                    <button class="btn btn-primary" onclick="switchTab('profile')">
                                        <i class="icon-edit"></i>
                                        Редактировать
                                    </button>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            <i class="icon-logout"></i>
                                            Выйти
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- История бронирований -->
                    <div class="tab-content" id="bookings">
                        <div class="dashboard-card full-width">
                            <h2>
                                <i class="icon-calendar"></i>
                                История бронирований
                            </h2>

                            <ul class="booking-list">
                                @forelse($bookings as $booking)
                                <li class="booking-item">
                                    <div class="booking-info">
                                        <h3 class="booking-title">{{ $booking->tariff->name }}</h3>
                                        <div class="booking-meta">
                                            <span>
                                                <i class="icon-clock"></i>
                                                {{ $booking->hours }} часов
                                            </span>
                                            <span>
                                                <i class="icon-users"></i>
                                                {{ $booking->people }} человек
                                            </span>
                                            <span>
                                                <i class="icon-calendar"></i>
                                                {{ $booking->created_at->format('d.m.Y') }}
                                            </span>
                                            <span>
                                                <i class="icon-dollar"></i>
                                                {{ $booking->total_price }} руб.
                                            </span>
                                        </div>
                                        @if($booking->comment)
                                        <div class="booking-comment">
                                            <i class="icon-message"></i>
                                            {{ $booking->comment }}
                                        </div>
                                        @endif
                                    </div>
                                    <span class="booking-status status-{{ $booking->status }}">
                                        @if($booking->status == 'active')
                                        Активно
                                        @elseif($booking->status == 'completed')
                                        Завершено
                                        @elseif($booking->status == 'cancelled')
                                        Отменено
                                        @endif
                                    </span>
                                </li>
                                @empty
                                <li class="booking-item">
                                    <p>У вас пока нет бронирований</p>
                                </li>
                                @endforelse
                            </ul>

                            <div class="pagination">
                                {{ $bookings->links() }}
                            </div>
                        </div>
                    </div>

                    <!-- Вкладка Личные данные -->
                    <div class="tab-content" id="profile">
                        <div class="dashboard-card full-width">
                            <h2>
                                <i class="icon-user"></i>
                                Редактирование профиля
                            </h2>

                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="first_name">Имя</label>
                                    <input type="text" id="first_name" name="first_name" class="form-control" value="{{ $user->first_name }}">
                                </div>

                                <div class="form-group">
                                    <label for="last_name">Фамилия</label>
                                    <input type="text" id="last_name" name="last_name" class="form-control" value="{{ $user->last_name }}">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}">
                                </div>

                                <div class="form-group">
                                    <label for="phone">Телефон</label>
                                    <input type="tel" id="phone" name="phone" class="form-control" value="{{ $user->phone }}">
                                </div>

                                <div class="dashboard-actions">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="icon-save"></i>
                                        Сохранить изменения
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Вкладка Безопасность -->
                    <div class="tab-content" id="security">
                        <div class="dashboard-card">
                            <h2>
                                <i class="icon-lock"></i>
                                Смена пароля
                            </h2>

                            <form action="{{ route('password.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="current_password">Текущий пароль</label>
                                    <input type="password" id="current_password" name="current_password" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="password">Новый пароль</label>
                                    <input type="password" id="password" name="password" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Подтвердите пароль</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                                </div>

                                <div class="dashboard-actions">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="icon-lock"></i>
                                        Сменить пароль
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="dashboard-card">
                            <h2>
                                <i class="icon-logout"></i>
                                Выход из аккаунта
                            </h2>

                            <p style="color: white; margin-bottom : 20px;">Нажмите кнопку ниже, чтобы выйти из своего аккаунта.</p>

                            <div class="dashboard-actions">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        <i class="icon-logout"></i>
                                        Выйти
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <footer class="footer">
            <img src="{{ asset ('/img/background/background-footer.png') }}"
                class="background-image" alt="Footer Background">
            <div class="footer-content">
                <div class="footer-logo-container">
                    <a href="#">
                        <img src="/img/LOGO.png" alt="Cyber Arena Logo" class="footer-logo">
                    </a>
                </div>

                <div class="footer-info">
                    <div class="footer-column">
                        <h3 class="footer-heading">ИНФОРМАЦИЯ</h3>
                        <div class="footer-divider"></div>
                        <nav class="footer-links">
                            <a href="#" class="footer-link">О нас</a>
                            <a href="#" class="footer-link">Контакты</a>
                            <a href="#" class="footer-link">Политика конф.</a>
                        </nav>
                    </div>
                </div>

                <div class="footer-contacts">
                    <div class="footer-column">
                        <h3 class="footer-heading">КОНТАКТЫ</h3>
                        <div class="footer-divider"></div>
                        <div class="footer-address">
                            <p>Иркутск, Ленина 5А</p>
                            <p class="phone-number">(812) 444-33-11</p>
                            <p class="email">shop@shop.ru</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <script src="{{ asset('js/dashboard.js') }}"></script>
    </div>

</body>

</html>