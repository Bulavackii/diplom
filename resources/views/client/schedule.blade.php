@extends('layouts.client')

@section('title', 'Расписание')

@section('header')
    <div class="section-title text-center" style="margin-bottom: 5px;">
        Расписание
    </div>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            @if($seances->isEmpty())
                <p class="text-white text-center">В настоящее время нет доступных сеансов.</p>
            @else
                <div class="col-md-6"> <!-- Уменьшаем ширину колонок до 6 -->
                    <div class="list-group">
                        @foreach($seances as $seance)
                            <div class="list-group-item list-group-item-action mb-3 shadow-lg">
                                <div class="d-flex align-items-center">
                                    <!-- Постер фильма -->
                                    @if ($seance->movie->poster_url)
                                        <img src="{{ asset($seance->movie->poster_url) }}" class="img-fluid movie-poster mr-3" alt="{{ $seance->movie->title }}">
                                    @endif
                                    <!-- Информация о сеансе -->
                                    <div class="ml-3"> <!-- Добавлен отступ слева -->
                                        <h5 class="mb-1 text-dark font-weight-bold">{{ $seance->movie->title }}</h5>
                                        <p class="mb-1 text-dark">
                                            <strong>Время:</strong> {{ $seance->start_time->format('d.m.Y H:i') }}<br>
                                            <strong>Зал:</strong> {{ $seance->cinemaHall->name }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-center mt-3">
                                    <a href="{{ route('client.hall', $seance->id) }}" class="btn btn-warning btn-sm">
                                        Забронировать билеты
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Стили для заголовка */
        .section-title {
            font-size: 2rem;
            font-weight: bold;
            color: #fff;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 10px;
            width: 30%;
            margin: 0 auto 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        body {
            background-image: url('{{ asset('client/i/background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        /* Стили для карточек расписания */
        .list-group-item {
            border-radius: 15px;
            padding: 20px;
            background-color: #fff;
        }

        /* Постеры фильмов */
        .movie-poster {
            width: 80px;  /* Ширина постера */
            height: auto;
            border-radius: 10px;
        }

        /* Добавляем отступ между постером и текстом */
        .ml-3 {
            margin-left: 20px;
        }

        /* Кнопка "Забронировать билеты" */
        .btn-warning {
            background-color: #ffc107;
            color: #000;
            border-radius: 20px;
            transition: background-color 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        /* Типографика */
        .text-dark {
            color: #333;
        }

        /* Отступы между элементами списка */
        .list-group-item + .list-group-item {
            margin-top: 15px;
        }

        /* Выравнивание заголовков и текста */
        h5, p {
            text-align: center;
        }
    </style>
@endpush
