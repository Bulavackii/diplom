@extends('layouts.client')

@section('title', 'Сеансы')

@section('header')
    <div class="section-title text-center">
        Сеансы
    </div>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            @if($movies->isEmpty())
                <p class="text-white text-center">В настоящее время нет доступных сеансов.</p>
            @else
                @foreach($movies->chunk(3) as $movieChunk)
                    <div class="row justify-content-center mb-4"> <!-- Центрирование карточек в ряду -->
                        @foreach($movieChunk as $movieGroup)
                            @php
                                $firstSession = $movieGroup->first();
                                $movie = $firstSession->movie;
                            @endphp
                            <div class="col-sm-6 col-md-4 d-flex justify-content-center align-items-stretch">
                                <div class="card movie-card shadow-lg mb-4">
                                    @if($movie->poster_url)
                                        <img src="{{ asset($movie->poster_url) }}" class="card-img-top movie-poster" alt="{{ $movie->title }}">
                                    @endif
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <div>
                                            <h5 class="card-title">{{ $movie->title }}</h5>
                                            <p class="card-text">
                                                {{ Str::limit($movie->description, 100) }}
                                                <a href="{{ route('client.movie.details', $movie->id) }}" class="text-primary">
                                                    Подробнее <i class="bi bi-info-circle-fill"></i>
                                                </a>
                                            </p>
                                            <p><strong>Длительность:</strong> {{ $movie->duration }} минут</p>
                                            <p><strong>Жанр:</strong> {{ $movie->genre }}</p>
                                            <p><strong>Страна:</strong> {{ $movie->country }}</p>
                                            <h6><strong>Доступные сеансы:</strong></h6>
                                            <ul class="list-unstyled">
                                                @foreach($movieGroup as $session)
                                                    <li class="mb-2">
                                                        <span><strong>Время:</strong> {{ $session->start_time->format('d.m.Y H:i') }} <strong>в зале</strong> {{ $session->cinemaHall->name }}</span>
                                                        <a href="{{ route('client.hall', $session->id) }}" class="btn btn-sm btn-warning mt-2">
                                                            Забронировать билеты
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
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

        /* Карточка сеанса */
        .movie-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            max-width: 350px;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .movie-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        /* Изображение постера */
        .movie-poster {
            height: 400px;
            object-fit: cover;
            border-radius: 15px 15px 0 0;
        }

        /* Текст и стили внутри карточки */
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }
        .card-text {
            font-size: 1.2rem;
            color: #555;
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

        /* Центрирование карточек */
        .row.justify-content-center {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .col-sm-6.col-md-4 {
            display: flex;
            justify-content: center;
        }

        /* Высота карточек и выравнивание содержимого */
        .d-flex.align-items-stretch {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-grow: 1;
        }
    </style>
@endpush
