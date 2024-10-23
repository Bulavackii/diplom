<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Админ Панель</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Подключение стилей -->
    <link rel="stylesheet" href="{{ asset('ad/css/style.css') }}">

    <style>
        body {
            background-image: url('{{ asset('ad/i/background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex-grow: 1;
        }

        footer {
            margin-top: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        footer p {
            margin: 0;
            color: #fff;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Стили для эмблемы */
        .navbar-brand img {
            height: 50px; /* Увеличена высота логотипа */
            width: auto;
            border: 2px solid #ffc107; /* Добавлена контрастная рамка */
            border-radius: 10px; /* Слегка скругленные углы */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Тень */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Анимация при наведении */
        }

        /* Эффект при наведении на эмблему */
        .navbar-brand img:hover {
            transform: scale(1.1); /* Увеличение размера */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3); /* Увеличение тени */
        }

        /* Стили для навигации */
        .navbar-nav .nav-link {
            display: flex;
            align-items: center; /* Вертикальное выравнивание иконки и текста */
            padding-left: 10px; /* Отступ для навигационных элементов */
            color: #fff;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link i {
            margin-right: 8px; /* Отступ между иконкой и текстом */
            color: #ffc107; /* Цвет иконки */
            transition: color 0.3s ease;
        }

        /* Эффект наведения на навигацию */
        .navbar-nav .nav-link:hover {
            color: #ffc107;
        }

        /* Иконка изменяет цвет при наведении */
        .navbar-nav .nav-link:hover i {
            color: #fff;
        }

        /* Эффект кнопки-гамбургера */
        .navbar-toggler {
            transition: all 0.3s ease;
        }

        .navbar-toggler:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('ad/i/logo.png') }}" alt="Эмблема Админ Панели"> <!-- Эмблема -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.index') }}">
                                <i class="fas fa-home"></i> Главная
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.movies.index') }}">
                                <i class="fas fa-film"></i> Фильмы
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.halls.index') }}">
                                <i class="fas fa-door-open"></i> Залы
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.seances.index') }}">
                                <i class="fas fa-clock"></i> Сеансы
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.users') }}">
                                <i class="fas fa-users"></i> Пользователи
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Выйти
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </header>

    <!-- Основной контент -->
    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Футер -->
    <footer class="bg-dark text-white text-center py-3">
        <p>© {{ date('Y') }} Админ Панель Кинотеатра. Все права защищены.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
