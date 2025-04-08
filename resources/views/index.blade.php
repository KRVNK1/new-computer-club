<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Arena - Эксклюзивный компьютерный клуб</title>
    <link rel="stylesheet" href="{{  asset('css/index.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800&family=Roboto:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>
    <div class="main-container">
        <header class="header">
            <img src="{{ asset ('/img/background/Backround-header.png') }}"
                class="background-image" alt="Background">
            <div class="header-content">
                <a href="#">
                    <img src="{{ asset ('/img/LOGO.png') }}"
                        class="logo" alt="Cyber Arena Logo">
                </a>

                <nav class="navigation">
                    <a href="#photos" class="nav-link">Фото</a>
                    <a href="#pricing" class="nav-link">Тарифы</a>
                    <a href="#specs" class="nav-link">Комплектующие</a>
                    <a href="#map" class="nav-link">Как добраться</a>
                    <a href="#login" class="login-button">Войти</a>
                </nav>

                <nav class="nav-menu-toggle">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </nav>
            </div>
        </header>

        <section class="hero-section">
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

        <section class="gallery-section">
            <img src="{{ asset ('/img/background/background-photo.png') }}"
                class="background-image" alt="Gallery Background">
            <div class="gallery-content" data-el="div-2">
                <div class="gallery-container">
                    <div class="gallery-item">
                        <img src="{{ asset ('/img/gallery/item1.png') }}"
                            class="gallery-image" alt="Gaming Setup 1">
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset ('/img/gallery/item2.png') }}"
                            class="gallery-image" alt="Gaming Setup 2">
                    </div>
                    <div class="gallery-item">
                        <img src="{{ asset ('/img/gallery/item3.png') }}"
                            class="gallery-image" alt="Gaming Setup 3">
                    </div>
                </div>
            </div>
        </section>

        <section class="tariff-section">
            <img src="{{ asset ('/img/background/background-tariffs.png') }}"
                class="background-image" alt="Hero Background">
            <div class="tariff-content">
                <div class="section-tariff-header">
                    <h2 class="section-title-highlight">ТАРИФЫ</h2>
                    <h2 class="section-title">ТАРИФЫ</h2>
                </div>
                <div class="pricing-grid">
                    <article class="pricing-card">
                        <div class="card-image-container">
                            <img
                                src="{{ asset ('/img/tariffs/pc1.png') }}"
                                alt="Standard Plan"
                                class="card-image" />
                        </div>
                        <div class="card-content">
                            <div class="card-info">
                                <h2 class="plan-name">STANDART</h2>
                                <p class="plan-price">1000 руб/сутки</p>
                            </div>
                            <div class="card-action">
                                <button class="select-button">Выбрать</button>
                            </div>
                        </div>
                    </article>
                    <article class="pricing-card">
                        <div class="card-image-container">
                            <img
                                src="{{ asset ('/img/tariffs/pc2.png') }}"
                                alt="Premium Plan"
                                class="card-image" />
                        </div>
                        <div class="card-content">
                            <div class="card-info">
                                <h2 class="plan-name">PREMIUM</h2>
                                <p class="plan-price">1166 руб/сутки</p>
                            </div>
                            <div class="card-action">
                                <button class="select-button">Выбрать</button>
                            </div>
                        </div>
                    </article>
                    <article class="pricing-card">
                        <div class="card-image-container">
                            <img
                                src="{{ asset ('/img/tariffs/pc3.png') }}"
                                alt="VIP Plan"
                                class="card-image" />
                        </div>
                        <div class="card-content">
                            <div class="card-info">
                                <h2 class="plan-name">VIP</h2>
                                <p class="plan-price">1500 руб/сутки</p>
                            </div>
                            <div class="card-action">
                                <button class="select-button">Выбрать</button>
                            </div>
                        </div>
                    </article>
                </div>
            </div>

        </section>

        <section class="specs-section">
            <img src="{{ asset ('/img/background/background-specs.png') }}"
                class="background-image" alt="Specs Background">
            <div class="specs-content">
                <div class="section-title-container">
                    <h2 class="section-title-highlight">КОМПЛЕКТУЮЩИЕ</h2>
                    <h2 class="section-title">КОМПЛЕКТУЮЩИЕ</h2>
                </div>
                <div class="tabs-container">
                    <button class="tab-button active">standart</button>
                    <button class="tab-button">boot camp</button>
                    <button class="tab-button">Vip</button>
                </div>
                <div class="specs-columns">
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
                                    Оперативная
                                    <br>
                                    память
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
            </div>
        </section>

        <section class="map-section" id="map">
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


</body>

</html>