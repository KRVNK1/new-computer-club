<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - Cyber Arena</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="{{  asset('css/global/global.css') }}">
    <link rel="stylesheet" href="{{  asset('css/global/media.css') }}">
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
                <a href="{{ route('profile') }}" class="login-button">Войти</a>
            </nav>

            <nav class="nav-menu-toggle">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </nav>
        </div>
    </header>

    <section class="auth-container">
        <div class="auth-form">

            <h1 class="auth-title">Регистрация</h1>

            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name">Имя</label>
                        <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="last_name">Фамилия</label>
                        <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="login">Логин</label>
                    <input id="login" type="text" class="form-control" name="login" value="{{ old('login') }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label for="phone">Телефон</label>
                    <input id="phone" type="tel" class="form-control" name="phone" value="{{ old('phone') }}" required>
                </div>

                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Подтверждение пароля</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary">Зарегистрироваться</button>

                <div class="auth-links">
                    <div class="auth-divider">
                        <span>или</span>
                    </div>

                    <a class="auth-link" href="{{ route('login') }}">Уже есть аккаунт? Войти</a>
                </div>
            </form>
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

    <script src="{{ asset('js/mobile-menu.js') }}"></script>

</body>

</html>