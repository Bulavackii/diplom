@extends('layouts.client')

@section('title', 'Мои билеты')

@section('header')
    <div class="section-title text-center" style="margin-bottom: 5px;">
        Мои билеты
    </div>
@endsection

@section('content')
    <div class="container mt-4">
        @if($tickets->isEmpty())
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="alert alert-info text-center">
                        У вас пока нет приобретенных билетов
                    </div>
                </div>
            </div>
        @else
            <div class="row justify-content-center">
                @foreach($tickets as $ticket)
                    <div class="col-sm-6 col-md-4 d-flex justify-content-center align-items-stretch mb-4">
                        <div class="card shadow-lg ticket-card">
                            <div class="card-header bg-primary text-white text-center">
                                <h5 class="card-title mb-0">{{ $ticket->seance->movie->title }}</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    <strong>Зал:</strong> {{ $ticket->seance->cinemaHall->name }}<br>
                                    <strong>Дата и время:</strong> {{ $ticket->seance->start_time->format('d.m.Y H:i') }}<br>
                                    <strong>Место:</strong> Ряд {{ $ticket->seat_row }}, Место {{ $ticket->seat_number }}
                                </p>
                                <div class="text-center">
                                    <a href="{{ asset($ticket->qr_code) }}" class="btn btn-warning btn-block" download="QR код">
                                        Скачать QR-код
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
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

        .ticket-card {
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .ticket-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card-body {
            padding: 20px;
            background-color: #f8f9fa;
        }

        .btn-warning {
            border-radius: 25px;
            padding: 10px 20px;
            background-color: #ffc107;
            color: #fff;
            transition: background-color 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .alert-info {
            background-color: #ffffff;
            color: rgb(0, 0, 0);
        }
    </style>
@endpush
