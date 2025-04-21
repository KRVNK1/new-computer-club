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
                        <label>ВРЕМЯ НАЧАЛА</label>
                        <input type="datetime-local" name="start_time" id="start_time" required>
                    </div>
                    <div class="booking-control">
                        <label>ВРЕМЯ ОКОНЧАНИЯ</label>
                        <input type="datetime-local" name="end_time" id="end_time" required>
                    </div>

                    <div class="booking-control">
                        <label>КОЛИЧЕСТВО ЧЕЛОВЕК</label>
                        <div class="quantity-control">
                            <button type="button" class="btn-minus">-</button>
                            <input type="number" name="people" id="people" value="1" min="1" max="{{ $maxPeople ?? 5 }}" readonly>
                            <button type="button" class="btn-plus">+</button>
                        </div>
                    </div>

                    <div class="total-price">
                        <h2>ОБЩАЯ СТОИМОСТЬ: <span id="totalPrice">{{ $tariff->price_per_hour}}</span> РУБ.</h2>
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
        const isRoom = "{{ $tariff->is_room ? 'true' : 'false' }}";
        let currentPeople = parseInt(document.getElementById("people").value);
        const maxPeople = Number.parseInt(document.getElementById("people").getAttribute("max"));

        const startTime = new Date(document.getElementById('start_time').value);
        const endTime = new Date(document.getElementById('end_time').value);

        const btnMinus = document.querySelector(".btn-minus");
        const btnPlus = document.querySelector(".btn-plus");

        document.getElementById("start_time").addEventListener("change", updateTotalPrice)
        document.getElementById("end_time").addEventListener("change", updateTotalPrice)

        btnMinus.addEventListener('click', () => {
            decrementPeople();
            
        })

        btnPlus.addEventListener('click', () => {
            incrementPeople();
        })

        function incrementPeople() {
            if (currentPeople < maxPeople) {
                currentPeople++;
                currentPeople.value = people;
                updateTotalPrice();
                console.log('message')
            }
        }

        function decrementPeople() {
            if (currentPeople > 1) {
                currentPeople--;
                currentPeople.value = people;
                updateTotalPrice();
            }
        }

        // бронирование на 4 часа
        function quickBook() {
            const now = new Date()
            const fourHours = new Date(now.getTime() + 4 * 60 * 60 * 1000)

            // Форматирование даты и времени для input datetime-local
            const formatDateTimeForInput = (date) => {
                const year = date.getFullYear()
                const month = String(date.getMonth() + 1).padStart(2, "0")
                const day = String(date.getDate()).padStart(2, "0")
                const hours = String(date.getHours()).padStart(2, "0")
                const minutes = String(date.getMinutes()).padStart(2, "0")

                return `${year}-${month}-${day}T${hours}:${minutes}`
            }

            document.getElementById("start_time").value = formatDateTimeForInput(now)
            document.getElementById("end_time").value = formatDateTimeForInput(fourHours)

            updateTotalPrice()
        }

        // обновления общей стоимости
        function updateTotalPrice() {
            const startTimeInput = document.getElementById("start_time").value;
            const endTimeInput = document.getElementById("end_time").value;

            if (!startTimeInput || !endTimeInput) {
                document.getElementById("totalPrice").textContent = basePrice;
                return;
            }

            const startTime = new Date(startTimeInput);
            const endTime = new Date(endTimeInput);

            if (isNaN(startTime.getTime()) || isNaN(endTime.getTime())) {
                document.getElementById("totalPrice").textContent = basePrice;
                return;
            }

            // Расчет разницы в часах
            const diffMs = endTime - startTime;
            const diffHours = Math.max(1, Math.ceil(diffMs / (1000 * 60 * 60)));

            // Расчет стоимости
            let totalPrice;
            if (isRoom) {
                // Для VIP - цена за всю комнату
                totalPrice = basePrice * diffHours;
            } else {
                // Для общего зала - цена за человека
                totalPrice = basePrice * diffHours * currentPeople;
            }

            document.getElementById("totalPrice").textContent = totalPrice;
        }

        updateTotalPrice()

    </script>

</body>

</html>