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
                <a href="{{ url('/index#gallery') }}" class="nav-link">Фото</a>
                <a href="{{ url('/index#tariffs') }}" class="nav-link">Тарифы</a>
                <a href="{{ url('/index#specs') }}" class="nav-link">Комплектующие</a>
                <a href="{{ url('/index#map') }}" class="nav-link">Как добраться</a>
                <a href="{{ route('profile') }}" class="login-button">Войти</a>
            </nav>

            <nav class="nav-menu-toggle">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </nav>
        </div>
    </header>



    <section class="booking-container">

        @if ($errors->has('comment'))
        <div class="alert alert-danger">
            {{ $errors->first('comment') }}
        </div>
        @endif

        <div class="booking-sides">
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
                            <h2>ЦЕНА ЗА ЧАС: {{ $tariff->price_per_hour }} РУБ.
                                @if($tariff->is_room)
                                (ЗА ВСЮ КОМНАТУ)
                                @else
                                (С 1 ЧЕЛ)
                                @endif
                            </h2>
                        </div>

                        <div class="booking-control">
                            <label>КОЛИЧЕСТВО ЧАСОВ</label>
                            <div class="quantity-control">
                                <button type="button" class="btn-minus" id="btn-minus-hours">-</button>
                                <input type="number" name="hours" id="hours" value="1" min="1" max="24" readonly>
                                <button type="button" class="btn-plus" id="btn-plus-hours">+</button>
                            </div>
                        </div>

                        <div class="booking-control" id="people-field">
                            <label>КОЛИЧЕСТВО ЧЕЛОВЕК</label>
                            <div class="quantity-control">
                                <button type="button" class="btn-minus" id="btn-minus-people">-</button>
                                <input type="number" name="people" id="people" value="1" min="1" max="{{ $maxPeople ?? 5 }}" readonly>
                                <button type="button" class="btn-plus" id="btn-plus-people">+</button>
                            </div>
                        </div>

                        <div class="total-price">
                            <h2>ОБЩАЯ СТОИМОСТЬ: <span id="totalPrice">{{ $tariff->price_per_hour }}</span> РУБ.</h2>
                        </div>

                        <button type="submit" class="btn-order">ОФОРМИТЬ ЗАКАЗ</button>
                    </div>
                </form>
            </div>

            <div class="booking-right">
                <h2>ОСТАВИТЬ КОММЕНТАРИЙ</h2>
                <textarea name="comment" form="bookingForm" class="comment-area" placeholder="Ваш комментарий (ограничение 100 символов)"></textarea>
                <button type="button" class="btn-quick-book" onclick="quickBook()">БРОНЬ НА 4 ЧАСА</button>
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

    <script src="{{ asset('js/mobile-menu.js') }}"></script>
    <script src="{{ asset('js/animations.js') }}"></script>
    <script>
        const basePrice = "{{ $tariff -> price_per_hour }}";
        const isRoom = "{{ $tariff -> is_room ? 'true' : 'false' }}";
        const type = "{{ $tariff -> name }}";

        const currentPeople = document.getElementById("people");
        const hoursInput = document.getElementById("hours");
        const maxPeople = Number.parseInt(document.getElementById("people").getAttribute("max"));

        const btnMinusPeople = document.querySelector("#btn-minus-people");
        const btnPlusPeople = document.querySelector("#btn-plus-people");
        const btnMinusHours = document.querySelector("#btn-minus-hours");
        const btnPlusHours = document.querySelector("#btn-plus-hours");

        if (type == 'VIP') {
            document.querySelector('#people-field').style = 'display:none;'
        }

        btnMinusPeople.addEventListener('click', () => {
            decrementPeople();
        })

        btnPlusPeople.addEventListener('click', () => {
            incrementPeople();
        })

        btnMinusHours.addEventListener('click', () => {
            decrementHours();
        })

        btnPlusHours.addEventListener('click', () => {
            incrementHours();
        })

        // Увеличение кол-ва человек
        function incrementPeople() {
            const currentPeopleValue = parseInt(currentPeople.value);
            if (currentPeopleValue < maxPeople) {
                currentPeople.value = currentPeopleValue + 1;
                updateTotalPrice();
            }
        }

        // Уменьшение кол-ва человек
        function decrementPeople() {
            const currentPeopleValue = parseInt(currentPeople.value);
            if (currentPeopleValue > 1) {
                currentPeople.value = currentPeopleValue - 1;
                updateTotalPrice();
            }
        }

        // Увеличение кол-ва часов
        function incrementHours() {
            const currentHoursValue = Number.parseInt(hoursInput.value)
            if (currentHoursValue < 24) {
                hoursInput.value = currentHoursValue + 1
                updateTotalPrice();
            }
        }

        // Уменьшение кол-ва часов
        function decrementHours() {
            const currentHoursValue = Number.parseInt(hoursInput.value)
            if (currentHoursValue > 1) {
                hoursInput.value = currentHoursValue - 1
                updateTotalPrice();
            }
        }

        // бронирование на 4 часа
        function quickBook() {
            hoursInput.value = 4
            updateTotalPrice()
        }

        // обновления общей стоимости
        function updateTotalPrice() {
            const currentPeopleValue = Number.parseInt(currentPeople.value)
            const hours = Number.parseInt(hoursInput.value)

            console.log("updateTotalPrice")
            // Расчет стоимости
            let totalPrice
            if (isRoom == "true") {
                console.log("updateTotalPrice - VIP комната")
                // Для VIP - цена за всю комнату
                totalPrice = basePrice * hours
            } else {
                console.log({
                    currentPeopleValue,
                    basePrice,
                    hours,
                })
                // Для общего зала - цена за человека
                totalPrice = basePrice * hours * currentPeopleValue
            }

                document.getElementById("totalPrice").textContent = totalPrice
        }
        updateTotalPrice()
    </script>

</body>

</html>