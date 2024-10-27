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
                <!-- Сообщение, если нет доступных сеансов -->
                <p class="text-white text-center">В настоящее время нет доступных сеансов.</p>
            @else
                <!-- Перебор фильмов, группируя по 3 в ряду -->
                @foreach($movies->chunk(3) as $movieChunk)
                    <div class="row justify-content-center mb-4">
                        @foreach($movieChunk as $movieGroup)
                            @php
                                // Получаем первый сеанс для каждого фильма
                                $firstSession = $movieGroup->first();
                                $movie = $firstSession->movie;
                            @endphp
                            <div class="col-sm-6 col-md-4 d-flex justify-content-center align-items-start">
                                <div class="card movie-card shadow-lg mb-4">
                                    @if($movie->poster_url)
                                        <!-- Отображение постера фильма -->
                                        <img src="{{ asset($movie->poster_url) }}" class="card-img-top movie-poster" alt="{{ $movie->title }}">
                                    @endif
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <div>
                                            <!-- Заголовок фильма и описание -->
                                            <h5 class="card-title">{{ $movie->title }}</h5>
                                            <p class="card-text">
                                                <!-- Описание фильма с ограничением длины -->
                                                {{ Str::limit($movie->description, 100) }}
                                                <a href="{{ route('client.movie.details', $movie->id) }}" class="text-primary">
                                                    Подробнее <i class="bi bi-info-circle-fill"></i>
                                                </a>
                                            </p>
                                            <!-- Длительность, жанр и страна фильма -->
                                            <p><strong>Длительность:</strong> {{ $movie->duration }} минут</p>
                                            <p><strong>Жанр:</strong> {{ $movie->genre }}</p>
                                            <p><strong>Страна:</strong> {{ $movie->country }}</p>
                                            <h6><strong>Доступные сеансы:</strong></h6>
                                            <ul class="list-unstyled">
                                                <!-- Перебор сеансов для текущего фильма -->
                                                @foreach($movieGroup as $session)
                                                    <li class="mb-2">
                                                        <!-- Информация о времени сеанса и зале -->
                                                        <span><strong>Время:</strong> {{ $session->start_time->format('d.m.Y H:i') }} <strong>в зале</strong> {{ $session->cinemaHall->name }}</span>
                                                        <!-- Кнопка для бронирования билетов -->
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
    <!-- Подключение стилей для страницы -->
    <link rel="stylesheet" href="{{ asset('client/css/index.css') }}">
@endpush
