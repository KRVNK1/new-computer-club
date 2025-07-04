<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование пользователя - Компьютерный клуб</title>
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
                <a href="{{ route('admin.users') }}" class="nav-item active">
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

                <a href="{{ route('admin.workstations') }}" class="nav-item">
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
                    <h2>Редактирование пользователя</h2>
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
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="first_name">Имя</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" value="{{ $user->first_name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="last_name">Фамилия</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" value="{{ $user->last_name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="login">Логин</label>
                            <input type="text" id="login" name="login" class="form-control" value="{{ $user->login }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Телефон</label>
                            <input type="text" id="phone" name="phone" class="form-control" value="{{ $user->phone }}" required>
                        </div>

                        <div class="form-group">
                            <label for="role">Роль</label>
                            @if($isCurrentUser)
                            <input type="text" class="form-control" value="{{ $user->role === 'admin' ? 'Администратор' : 'Пользователь' }}" readonly>
                            <small class="help-text text-warning">Вы не можете изменить свою собственную роль</small>
                            <input type="hidden" name="role" value="{{ $user->role }}">
                            @else
                            <select id="role" name="role" class="form-control" required>
                                <option value="client" {{ old('role', $user->role) == 'client' ? 'selected' : '' }}>Пользователь</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Администратор</option>
                            </select>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password">Новый пароль</label>
                            <input type="password" id="password" name="password" class="form-control">
                            <span class="help-text">Оставить пустым, если не хочется менять пароль</ы>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Подтверждение пароля</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-primary">
                                Сохранить изменения
                            </button>
                            <a href="{{ route('admin.users') }}" class="btn-secondary">
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