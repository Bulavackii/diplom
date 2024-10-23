@extends('layouts.client')

@section('content')
    <div class="container mt-4">
        <div class="movie card shadow-lg mx-auto" style="max-width: 700px; border-radius: 15px; overflow: hidden;"> <!-- Установили max-width и выровняли по центру -->
            <div class="row g-0">
                <div class="col-md-4">
                    @if ($movie->poster_url)
                        <img src="{{ asset($movie->poster_url) }}" alt="{{ $movie->title }}" class="movie__poster img-fluid rounded-start">
                    @endif
                </div>
                <div class="col-md-8 d-flex flex-column justify-content-between">
                    <div class="p-4">
                        <h1 class="movie__title">{{ $movie->title }}</h1>
                        <p class="movie__synopsis">
                            <strong>Описание:</strong> {{ $movie->description }}
                        </p>
                        <p class="movie__data"><strong>Жанр:</strong> {{ $movie->genre }}</p>
                        <p class="movie__data"><strong>Страна:</strong> {{ $movie->country }}</p>
                        <p class="movie__data"><strong>Длительность:</strong> {{ $movie->duration }} минут</p>
                    </div>

                    <div class="p-4">
                        <a href="{{ route('client.hall', $movie->id) }}" class="acceptin-button btn btn-primary btn-lg w-100">Бронировать билет</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        body {
            background-image: url('{{ asset('client/i/background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .movie__title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
        }
        .movie__synopsis {
            font-size: 1.2rem;
            color: #555;
        }
        .movie__data {
            font-size: 1.1rem;
            color: #444;
        }
        .acceptin-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            transition: background-color 0.3s ease;
        }
        .acceptin-button:hover {
            background-color: #0056b3;
        }
        .movie__poster {
            object-fit: cover;
            max-height: 100%;
        }

        /* Центрируем карточку и задаем фиксированную ширину */
        .movie.card {
            max-width: 700px;
            margin: 0 auto; /* Центрирование карточки */
        }
    </style>
@endpush
