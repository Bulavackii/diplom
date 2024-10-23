<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Cinema App')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome для иконок -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')
    <style>
        /* Улучшение читаемости текста */
        body {
            font-size: 1.1rem;
            line-height: 1.6;
            background-color: #f8f9fa;
            color: #333;
        }

        /* Навигация */
        .navbar {
            padding: 1rem 1.5rem;
            background-color: #e9ecef;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            transition: color 0.3s ease;
        }

        .navbar-brand:hover {
            color: #ff9800;
        }

        /* Убираем буллиты (точки) у элементов списка навигации */
        .navbar-nav {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0;
        }

        .navbar-nav .nav-item {
            margin-left: 10px;
        }

        .nav-link {
            color: #007bff;
            font-weight: 500;
            transition: color 0.3s ease, background-color 0.3s ease;
            padding: 0.5rem 1rem;
            position: relative;
            display: flex;
            align-items: center;
        }

        .nav-link i {
            margin-right: 8px;
            transition: transform 0.3s ease;
        }

        .nav-link:hover {
            color: #ff9800;
            background-color: #f1f1f1;
        }

        .nav-link:hover i {
            transform: scale(1.2);
        }

        /* Основной контент */
        header {
            margin-bottom: 2rem;
        }

        main {
            margin-bottom: 2rem;
        }

        .policy-content {
            max-width: 750px;
            margin: 0 auto;
            padding: 40px;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }

        .policy-content h2 {
            font-size: 2.5rem;
            color: #333;
            text-align: center;
            margin-bottom: 25px;
            font-weight: bold;
        }

        .policy-content p {
            font-size: 1.15rem;
            color: #444;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .policy-content a {
            color: #007bff;
            text-decoration: underline;
        }

        .policy-content a:hover {
            color: #ff9800;
        }

        /* Футер */
        footer {
            background-color: #f8f9fa;
            padding: 2rem 0;
            border-top: 1px solid #dee2e6;
        }

        footer p {
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        footer a {
            color: #007bff;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .footer-social-icons img {
            margin-right: 1rem;
            transition: transform 0.3s ease;
        }

        .footer-social-icons img:hover {
            transform: scale(1.2);
        }

        .footer-social-icons img {
            width: 30px;
            height: 30px;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Навигация -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-film"></i> Проект кинотеатра
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.movies') }}">
                            <i class="fas fa-film"></i> Фильмы
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.schedule') }}">
                            <i class="far fa-calendar-alt"></i> Расписание
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.contact') }}">
                            <i class="fas fa-envelope"></i> Контакты
                        </a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Войти
                            </a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus"></i> Регистрация
                                </a>
                            </li>
                        @endif
                    @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fas fa-user"></i> {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <!-- Меню пользователя -->
                            <a class="dropdown-item" href="{{ route('client.profile') }}">
                                <i class="fas fa-user-circle"></i> Профиль
                            </a>
                            <a class="dropdown-item" href="{{ route('client.tickets') }}">
                                <i class="fas fa-ticket-alt"></i> Мои билеты
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Выйти
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>                    
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Основной контент -->
    <header class="container mt-4">
        @yield('header')
    </header>
    
    <main class="flex-grow-1 container mt-5">
        <div class="policy-content">
            <h2>Пользовательское соглашение</h2>
            <p>Используя наш сайт, вы соглашаетесь с тем, что обязаны соблюдать все применимые законы и нормативные акты, а также условия настоящего соглашения. Вы обязуетесь не нарушать права третьих лиц и не использовать сайт для незаконных целей.</p>
            <p>Мы оставляем за собой право вносить изменения в настоящее соглашение. Продолжая использовать сайт после внесения изменений, вы подтверждаете свое согласие с новыми условиями.</p>
            <p>Личная информация, которую вы предоставляете, будет обработана в соответствии с нашей <a href="{{ route('client.privacy-policy') }}">Политикой конфиденциальности</a>. Вы соглашаетесь с тем, что ваши данные могут использоваться для предоставления услуг, улучшения нашего сервиса и отправки рекламных материалов.</p>
            <p>Вы обязуетесь предоставлять достоверную информацию и не использовать сайт для распространения ложной или вводящей в заблуждение информации.</p>
            <p>В случае нарушения условий данного соглашения, мы оставляем за собой право ограничить или прекратить ваш доступ к нашему сайту и услугам.</p>
        </div>
    </main>

    <!-- Футер -->
    <footer class="text-center text-lg-start py-4 mt-auto">
        <div class="container text-center">
            <p>© {{ date('Y') }} Проект кинотеатра. Все права защищены.</p>
            <p><strong>Остались вопросы? — Звоните: <a href="tel:+71234567890">+7 (123) 456-78-90</a></strong></p>
            <p>Следите за нами в соцсетях:</p>
            <div class="footer-social-icons">
                <a href="https://facebook.com" target="_blank">
                    <img src="{{ asset('client/icons/facebook.png') }}" alt="Facebook">
                </a>
                <a href="https://twitter.com" target="_blank">
                    <img src="{{ asset('client/icons/twitter.png') }}" alt="Twitter">
                </a>
                <a href="https://instagram.com" target="_blank">
                    <img src="{{ asset('client/icons/instagram.png') }}" alt="Instagram">
                </a>
                <a href="https://vk.com" target="_blank">
                    <img src="{{ asset('client/icons/vk.png') }}" alt="VK">
                </a>
            </div>
            <a href="{{ route('client.privacy-policy') }}">Согласие</a> | <a href="{{ route('client.contact') }}">Контакты</a>
        </div>
    </footer>

      <!-- Подключение Bootstrap JS и Popper.js -->
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
      
      <!-- Скрипт для предотвращения добавления # в URL -->
      <script>
        document.addEventListener('DOMContentLoaded', function() {
            var dropdowns = document.querySelectorAll('.dropdown-toggle');
            dropdowns.forEach(function(dropdown) {
                dropdown.addEventListener('click', function(event) {
                    event.preventDefault();
                    new bootstrap.Dropdown(dropdown); // Явная инициализация
                });
            });
        });
    </script>    
  
      @stack('scripts')
</body>
</html>
