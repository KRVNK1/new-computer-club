<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Бронирование мест</title>
    <link rel="stylesheet" href="{{  asset('css/global.css') }}">
    <link rel="stylesheet" href="{{  asset('css/booking.css') }}">
    <link rel="stylesheet" href="{{  asset('css/media.css') }}">
    <link rel="stylesheet" href="{{  asset('css/animations.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800&family=Roboto:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>
    <header class="header">
        <img src="{{ asset ('/img/background/background-header.png') }}"
            class="background-image" alt="Background">
        <div class="header-content">
            <a href="#">
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

    <section class="booking">
        
    </section>

    <footer class="footer">
        <img src="{{ asset ('/img/background/background-footer.png') }}"
            class="background-image" alt="Footer Background">
        <div class="footer-content">
            <a href="#">
                <img src="{{ asset ('/img/LOGO.png') }}"
                    class="footer-logo" alt="Cyber Arena Logo">

            </a>
            <div class="footer-info">
                <div class="footer-divider"></div>
                <div class="footer-column">
                    <h3 class="footer-heading">ИНФОРМАЦИЯ</h3>
                    <nav class="footer-links">
                        <a href="#about" class="footer-link">О нас</a>
                        <a href="#services" class="footer-link">Услуги</a>
                        <a href="#contacts" class="footer-link">Контакты</a>
                        <a href="#policy" class="footer-link">Политика конф.</a>
                    </nav>
                </div>
            </div>
            <div class="footer-contacts">
                <div class="footer-divider"></div>
                <div class="footer-column">
                    <h3 class="footer-heading">КОНТАКТЫ</h3>
                    <address class="footer-address">
                        <p>
                            Санкт-Петербург,
                            <br>
                            Невский пр. 140
                        </p>
                        <p class="phone-number">(812) 444-33-11</p>
                        <p class="email">shop@shop.ru</p>
                    </address>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/animations.js') }}"></script>


</body>

</html>