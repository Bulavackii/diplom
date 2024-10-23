@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-dark text-white text-center">
                <h2 class="mb-0">Административная панель</h2>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="row mt-4 justify-content-center">
                    <div class="col-md-3 col-sm-6">
                        <div class="card admin-card text-white bg-info mb-4 shadow-sm">
                            <div class="card-header text-center">
                                <i class="fas fa-users fa-2x"></i>
                                <div>Пользователи</div>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title">Админы и гости</h5>
                                <p class="card-text">Всего администраторов: {{ $adminsCount }}<br>Всего гостей: {{ $guestsCount }}</p>
                                <a href="{{ route('admin.users') }}" class="btn btn-light">Подробнее</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card admin-card text-white bg-primary mb-4 shadow-sm">
                            <div class="card-header text-center">
                                <i class="fas fa-door-open fa-2x"></i>
                                <div>Управление Залами</div>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title">Залы Кинотеатра</h5>
                                <p class="card-text">Действия с залами кинотеатра.</p>
                                <a href="{{ route('admin.halls.index') }}" class="btn btn-light">Перейти</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card admin-card text-white bg-success mb-4 shadow-sm">
                            <div class="card-header text-center">
                                <i class="fas fa-film fa-2x"></i>
                                <div>Управление Сеансами</div>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title">Сеансы Фильмов</h5>
                                <p class="card-text">Создание и управление сеансами фильмов.</p>
                                <a href="{{ route('admin.seances.index') }}" class="btn btn-light">Перейти</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card admin-card text-white bg-warning mb-4 shadow-sm">
                            <div class="card-header text-center">
                                <i class="fas fa-video fa-2x"></i>
                                <div>Управление Фильмами</div>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title">Фильмы</h5>
                                <p class="card-text">Добавление и управление фильмами в системе.</p>
                                <a href="{{ route('admin.movies.index') }}" class="btn btn-light">Перейти</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Подключение FontAwesome для иконок --}}
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <style>
        /* Стиль карточек */
        .admin-card {
            border-radius: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .admin-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        /* Текст заголовков и иконок */
        .admin-card .card-header {
            font-size: 1.25rem;
            font-weight: bold;
            text-transform: uppercase;
        }
        .admin-card i {
            display: block;
            margin-bottom: 10px;
        }

        /* Кнопки */
        .btn-light {
            border-radius: 20px;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }
        .btn-light:hover {
            background-color: #e0e0e0;
        }

        /* Цвета для карточек */
        .bg-info {
            background-color: #17a2b8 !important;
        }
        .bg-primary {
            background-color: #007bff !important;
        }
        .bg-success {
            background-color: #28a745 !important;
        }
        .bg-warning {
            background-color: #c07f2b !important;
        }
    </style>
@endsection
