<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <link rel="stylesheet" href="{{  asset('css/confirmation.css') }}">
    <link rel="stylesheet" href="{{  asset('css/global/global.css') }}">
    <link rel="stylesheet" href="{{  asset('css/global/media.css') }}">
    <link rel="stylesheet" href="{{  asset('css/global/animations.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800&family=Roboto:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>
    <header class="header">
        <img src="{{ asset ('/img/background/background-header.png') }}"
            class="background-image" alt="Background">
        <div class="header-content">
            <a href="{{ route('index') }}">
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

    <div class="booking-confirmation">
        <div class="confirmation-container">
            <div class="confirmation-header">
                <h1>Бронирование подтверждено!</h1>
                <div class="confirmation-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
            </div>

            <div class="confirmation-details">
                <div class="confirmation-section">
                    <h2>Детали бронирования</h2>
                    <div class="detail-row">
                        <span class="detail-label">Номер бронирования:</span>
                        <span class="detail-value">#{{ $booking->id }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Дата создания:</span>
                        <span class="detail-value">{{ $booking->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Статус:</span>
                        <span class="detail-value status-{{ $booking->status }}">
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
                    </div>
                </div>

                <div class="confirmation-section">
                    <h2>Информация о тарифе</h2>
                    <div class="detail-row">
                        <span class="detail-label">Тариф:</span>
                        <span class="detail-value">{{ $booking->tariff->name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Рабочая станция:</span>
                        <span class="detail-value">{{ $booking->workstation->number }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Количество часов:</span>
                        <span class="detail-value">{{ $booking->hours }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Количество человек:</span>
                        <span class="detail-value">{{ $booking->people }}</span>
                    </div>
                    @if($booking->comment)
                    <div class="detail-row">
                        <span class="detail-label">Комментарий:</span>
                        <span class="detail-value">{{ $booking->comment }}</span>
                    </div>
                    @endif
                </div>

                <div class="confirmation-section">
                    <h2>Информация о клиенте</h2>
                    <div class="detail-row">
                        <span class="detail-label">Имя:</span>
                        <span class="detail-value">{{ $booking->user->first_name }} {{ $booking->user->last_name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value">{{ $booking->user->email }}</span>
                    </div>
                    @if($booking->user->phone)
                    <div class="detail-row">
                        <span class="detail-label">Телефон:</span>
                        <span class="detail-value">{{ $booking->user->phone }}</span>
                    </div>
                    @endif
                </div>

                <div class="confirmation-section">
                    <h2>Оплата</h2>
                    <div class="detail-row total-price">
                        <span class="detail-label">Итоговая стоимость:</span>
                        <span class="detail-value">{{ number_format($booking->total_price, 0, '.', ' ') }} ₽</span>
                    </div>
                    <div class="payment-info">
                        <p>Оплата производится на месте перед началом игры.</p>
                    </div>
                </div>
            </div>

            <div class="confirmation-actions">
                <a href="{{ route('profile') }}" class="btn btn-primary">Перейти в личный кабинет</a>
                <a href="{{ url('/') }}" class="btn btn-secondary">Вернуться на главную</a>
            </div>
        </div>
    </div>

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
</body>

</html>