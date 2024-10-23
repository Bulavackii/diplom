@extends('layouts.client')

@section('title', 'Фильмы')

@section('header')
    <div class="section-title text-center" style="margin-bottom: 5px;">
        Фильмы
    </div>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            @if($movies->isEmpty())
                <p class="text-white text-center">На данный момент фильмы отсутствуют.</p>
            @else
                @foreach($movies as $movie)
                    <div class="col-sm-6 col-md-4 d-flex justify-content-center align-items-stretch">
                        <div class="card movie-card shadow-lg mb-4">
                            @if ($movie->poster_url)
                                <img src="{{ asset($movie->poster_url) }}" class="card-img-top movie-poster" alt="{{ $movie->title }}">
                            @endif
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title">{{ $movie->title }}</h5>
                                    <p class="card-text">{{ Str::limit($movie->description, 100) }}</p>
                                </div>
                                <div class="text-center mt-3">
                                    <a href="{{ route('client.movie.details', $movie->id) }}" class="btn btn-warning btn-block">Подробнее</a>
                                </div>
                            </div>
                        </div>
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

        body {
            background-image: url('{{ asset('client/i/background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        /* Карточка фильма */
        .movie-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            max-width: 350px; /* Увеличиваем ширину карточки */
            height: 100%; /* Делаем карточки одинаковой высоты */
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

        /* Кнопка "Подробнее" */
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
