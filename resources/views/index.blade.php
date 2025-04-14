<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Arena - Эксклюзивный компьютерный клуб</title>
    <link rel="stylesheet" href="{{  asset('css/global/global.css') }}">
    <link rel="stylesheet" href="{{  asset('css/global/media.css') }}">
    <link rel="stylesheet" href="{{  asset('css/global/animations.css') }}">
    <link rel="stylesheet" href="{{  asset('css/index.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800&family=Roboto:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>
    <div class="main-container">

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

        <section class="hero-section fade-in">
            <img src="{{ asset ('/img/background/background-main.png') }} "
                class="background-image" alt="Hero Background">
            <div class="hero-content">
                <div class="hero-text">
                    <h2 class="hero-subtitle">
                        Эксклюзивный компьютерный клуб
                    </h2>
                    <div class="hero-title">
                        <h1 class="hero-title__main">Cyber arena</h1>
                        <h1 class="hero-title__second">Cyber arena</h1>
                    </div>

                    <ul class="feature-list">
                        <li class="feature-item">Уникальный интерьер</li>
                        <li class="feature-item">топовое железо</li>
                        <li class="feature-item">Лаундж зона и кофе бар</li>
                    </ul>
                    <a href="#booking" class="booking-button">Забронировать</a>
                </div>
                <div class="hero-image-container">
                    <img src="{{ asset ('/img/hero.png') }} " alt="hero">
                </div>
            </div>
        </section>

        <section id="gallery" class="gallery-section fade-in">
            <img src="{{ asset ('/img/background/background-photo.png') }}"
                class="background-image" alt="Gallery Background">
            <div class="gallery-content" data-el="div-2">
                <div class="gallery-container">
                    <div class="gallery-item">
                        <img src="{{ asset ('/img/gallery/item1.png') }}"
                            class="gallery-image" alt="Gaming Setup 1">
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset ('/img/gallery/item3.png') }}"
                            class="gallery-image" alt="Gaming Setup 3">
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset ('/img/gallery/item2.png') }}"
                            class="gallery-image" alt="Gaming Setup 2">
                    </div>

                </div>
            </div>
        </section>

        <section id="tariffs" class="tariff-section fade-in">
            <img src="{{ asset ('/img/background/background-tariffs.png') }}"
                class="background-image" alt="Hero Background">
            <div class="tariff-content">
                <div class="section-tariff-header">
                    <h2 class="section-title-highlight">ТАРИФЫ</h2>
                </div>
                <div class="pricing-grid">
                    @foreach($tariffs as $tariff)
                    <article class="pricing-card">
                        <div class="card-image-container">
                            <img
                                src="{{ asset($tariff->image) }}"
                                alt="{{ $tariff->name }} Plan"
                                class="card-image" />
                        </div>
                        <div class="card-content">
                            <div class="card-info">
                                <h2 class="plan-name">{{ strtoupper($tariff->name) }}</h2>
                                <p class="plan-price">{{ $tariff->price_per_hour * 24 }} руб/сутки</p>
                            </div>
                            <div class="card-btn">
                                <a href="{{ route('booking.show', $tariff->id) }}" class="select-button">Выбрать</a>
                            </div>
                        </div>
                    </article>
                    @endforeach

                </div>
            </div>

        </section>

        <section id="specs" class="specs-section fade-in">
            <img src="{{ asset ('/img/background/background-specs.png') }}"
                class="background-image" alt="Specs Background">
            <div class="specs-content">
                <div class="section-title-container">
                    <h2 class="specs-title" data-text="КОМПЛЕКТУЮЩИЕ">КОМПЛЕКТУЮЩИЕ</h2>
                </div>
                <div class="tabs-container">
                    <button class="tab-button active">standart</button>
                    <button class="tab-button">boot camp</button>
                    <button class="tab-button">Vip</button>
                </div>
                <div class="specs-columns active fade-in">
                    <div class="specs-column">
                        <div class="specs-card">
                            <h3 class="specs-category">конфигурация</h3>
                            <div class="specs-item">
                                <h4 class="specs-name">Процессор</h4>
                                <p class="specs-value">
                                    Intel core
                                    <br>
                                    i5-12400F
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                            <div class="specs-item">
                                <h4 class="specs-name">Видеокарта</h4>
                                <p class="specs-value">
                                    rtx
                                    <br>
                                    4060
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                            <div class="specs-item">
                                <h4 class="specs-name">
                                    Оперативная память
                                </h4>
                                <p class="specs-value">
                                    16 gb
                                    <br>
                                    3200 mhz
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                            <div class="specs-item">
                                <h4 class="specs-name">Жесткий диск</h4>
                                <p class="specs-value">
                                    nvime ssd
                                    <br>
                                    256 gb
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                        </div>
                    </div>
                    <div class="specs-column peripherals">
                        <div class="specs-card">
                            <h3 class="specs-category">периферия</h3>
                            <div class="specs-item">
                                <h4 class="specs-name">Наушники</h4>
                                <p class="specs-value">
                                    hyperx
                                    <br>
                                    cloud 2
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                            <div class="specs-item">
                                <h4 class="specs-name">Мышь</h4>
                                <p class="specs-value">
                                    lamzu atlantis
                                    <br>
                                    (black)
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                            <div class="specs-item">
                                <h4 class="specs-name">Клавиатура</h4>
                                <p class="specs-value">
                                    lunacy
                                    <br>
                                    in space
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                            <div class="specs-item">
                                <h4 class="specs-name">Монитор</h4>
                                <p class="specs-value">
                                    fragmachine
                                    <br>
                                    27.5", 240 гц
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                        </div>
                    </div>
                </div>
                <div class="specs-columns fade-in">
                    <div class="specs-column">
                        <div class="specs-card">
                            <h3 class="specs-category">конфигурация</h3>
                            <div class="specs-item">
                                <h4 class="specs-name">Процессор</h4>
                                <p class="specs-value">
                                    Intel core
                                    <br>
                                    i5-13600KF
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                            <div class="specs-item">
                                <h4 class="specs-name">Видеокарта</h4>
                                <p class="specs-value">
                                    rtx
                                    <br>
                                    4060 TI
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                            <div class="specs-item">
                                <h4 class="specs-name">
                                    Оперативная память
                                </h4>
                                <p class="specs-value">
                                    32 gb
                                    <br>
                                    3200 mhz
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                            <div class="specs-item">
                                <h4 class="specs-name">Жесткий диск</h4>
                                <p class="specs-value">
                                    nvime ssd
                                    <br>
                                    256 gb
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                        </div>
                    </div>
                    <div class="specs-column peripherals">
                        <div class="specs-card">
                            <h3 class="specs-category">периферия</h3>
                            <div class="specs-item">
                                <h4 class="specs-name">Наушники</h4>
                                <p class="specs-value">
                                    hyperx
                                    <br>
                                    cloud 2
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                            <div class="specs-item">
                                <h4 class="specs-name">Мышь</h4>
                                <p class="specs-value">
                                    lamzu atlantis
                                    <br>
                                    (black)
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                            <div class="specs-item">
                                <h4 class="specs-name">Клавиатура</h4>
                                <p class="specs-value">
                                    lunacy
                                    <br>
                                    in space
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                            <div class="specs-item">
                                <h4 class="specs-name">Монитор</h4>
                                <p class="specs-value">
                                    fragmachine
                                    <br>
                                    27.5", 240 гц
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                        </div>
                    </div>
                </div>
                <div class="specs-columns fade-in">
                    <div class="specs-column">
                        <div class="specs-card">
                            <h3 class="specs-category">конфигурация</h3>
                            <div class="specs-item">
                                <h4 class="specs-name">Процессор</h4>
                                <p class="specs-value">
                                    Intel core
                                    <br>
                                    i7-13700F
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                            <div class="specs-item">
                                <h4 class="specs-name">Видеокарта</h4>
                                <p class="specs-value">
                                    rtx
                                    <br>
                                    4070 super
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                            <div class="specs-item">
                                <h4 class="specs-name">
                                    Оперативная память
                                </h4>
                                <p class="specs-value">
                                    32 gb
                                    <br>
                                    3200 mhz
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                            <div class="specs-item">
                                <h4 class="specs-name">Жесткий диск</h4>
                                <p class="specs-value">
                                    nvime ssd
                                    <br>
                                    256 gb
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                        </div>
                    </div>
                    <div class="specs-column peripherals">
                        <div class="specs-card">
                            <h3 class="specs-category">периферия</h3>
                            <div class="specs-item">
                                <h4 class="specs-name">Наушники</h4>
                                <p class="specs-value">
                                    logitech
                                    <br>
                                    g pro x
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                            <div class="specs-item">
                                <h4 class="specs-name">Мышь</h4>
                                <p class="specs-value">
                                    g pro
                                    <br>
                                    superlight
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                            <div class="specs-item">
                                <h4 class="specs-name">Клавиатура</h4>
                                <p class="specs-value">
                                    dark project
                                    <br>
                                    landau
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                            <div class="specs-item">
                                <h4 class="specs-name">Монитор</h4>
                                <p class="specs-value">
                                    Asus TUF
                                    <br>
                                    27.5", 280 гц
                                </p>
                            </div>
                            <div class="specs-divider"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="map-section fade-in" id="map">
            <img src="{{ asset ('/img/background/background-map.png') }}"
                class="background-image" alt="Map Background">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2442.286145079853!2d104.33602099191262!3d52.25634870326969!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5da83c78d0d719df%3A0xa314048ed68d1175!2z0JHQsNC50LrQsNC70YzRgdC60LDRjyDRg9C7Liwg0JjRgNC60YPRgtGB0LosINCY0YDQutGD0YLRgdC60LDRjyDQvtCx0LsuLCA2NjQwNzU!5e0!3m2!1sru!2sru!4v1742996734020!5m2!1sru!2sru"
                width="1080" height="770" style="border:1px solid; z-index: 10; border-radius: 10px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
    </div>

    <script src="{{ asset('js/tabs.js') }}"></script>
    <script src="{{ asset('js/animations.js') }}"></script>

</body>

</html>