<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Бронирование мест</title>
    <link rel="stylesheet" href="{{  asset('css/booking.css') }}">
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

    <section class="booking-container">
    
        <div class="booking-left">
            <div class="tariff-header">
                <div class="tariff-image">
                    <img src="{{ asset($tariff->image) }}" alt="{{ $tariff->name }}">
                </div>
                <div class="tariff-title">
                    <h1>{{ $tariff->name }}</h1>
                    <p>КОЛИЧЕСТВО СВОБОДНЫХ МЕСТ: {{ $availableSpots }}</p>
                </div>
            </div>

            <form action="{{ route('booking.store', $tariff->id) }}" method="POST" id="bookingForm">
                @csrf
                <div class="booking-details">
                    <div class="price-info">
                        <h2>ЦЕНА ЗА ЧАС: {{ $tariff->price_per_hour }} РУБ. (С 1 ЧЕЛ)</h2>
                    </div>

                    <div class="booking-control">
                        <label>КОЛИЧЕСТВО ЧАСОВ</label>
                        <div class="quantity-control">
                            <button type="button" class="btn-minus" onclick="decrementHours()">-</button>
                            <input type="number" name="hours" id="hours" value="24" min="1" max="24" readonly>
                            <button type="button" class="btn-plus" onclick="incrementHours()">+</button>
                        </div>
                    </div>

                    <div class="booking-control">
                        <label>КОЛИЧЕСТВО ЧЕЛОВЕК</label>
                        <div class="quantity-control">
                            <button type="button" class="btn-minus" onclick="decrementPeople()">-</button>
                            <input type="number" name="people" id="people" value="1" min="1" max="5" readonly>
                            <button type="button" class="btn-plus" onclick="incrementPeople()">+</button>
                        </div>
                    </div>

                    <div class="total-price">
                        <h2>ОБЩАЯ СТОИМОСТЬ: <span id="totalPrice">{{ $tariff->price_per_hour * 24 }}</span> РУБ.</h2>
                    </div>

                    <button type="submit" class="btn-order">ОФОРМИТЬ ЗАКАЗ</button>
                </div>
            </form>
        </div>

        <div class="booking-right">
            <h2>ОСТАВИТЬ КОММЕНТАРИЙ</h2>
            <textarea name="comment" form="bookingForm" class="comment-area" placeholder="Ваш комментарий..."></textarea>
            <button type="button" class="btn-quick-book" onclick="quickBook()">БРОНЬ НА 4 ЧАСА</button>
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

    <script src="{{ asset('js/animations.js') }}"></script>
    <script>

    const basePrice = "{{ $tariff -> price_per_hour }}";
    let hours = 24;
    let people = 1;

    function incrementHours() {
        if (hours < 24) {
            hours++;
            document.getElementById('hours').value = hours;
            updateTotalPrice();
        }
    }
    
    function decrementHours() {
        if (hours > 1) {
            hours--;
            document.getElementById('hours').value = hours;
            updateTotalPrice();
        }
    }
    

    function incrementPeople() {
        if (people < 5) {
            people++;
            document.getElementById('people').value = people;
            updateTotalPrice();
        }
    }
    
    function decrementPeople() {
        if (people > 1) {
            people--;
            document.getElementById('people').value = people;
            updateTotalPrice();
        }
    }
    
    // бронирование на 4 часа
    function quickBook() {
        hours = 4;
        document.getElementById('hours').value = hours;
        updateTotalPrice();
    }
    
    // обновления общей стоимости
    function updateTotalPrice() {
        const totalPrice = basePrice * hours * people;
        document.getElementById('totalPrice').textContent = totalPrice;
    }
</script>

</body>

</html>