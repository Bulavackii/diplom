@extends('layouts.client')

@section('title', 'Профиль')

@section('header')
    <div class="section-title text-center" style="margin-bottom: 5px;">
        Профиль
    </div>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="card shadow-lg" style="max-width: 600px; margin: 0 auto;">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <p class="h5 mb-4"><strong>Имя:</strong> {{ $user->name }}</p>
                        <p class="h5 mb-4"><strong>Email:</strong> {{ $user->email }}</p>
                        <hr>
                        <p class="text-muted text-center">Ваш профиль содержит основную информацию о вас, используемую для бронирования билетов и связи.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

        .card {
            border-radius: 10px;
            overflow: hidden;
            border: none;
        }

        .card-body {
            padding: 20px;
        }

        .h5 {
            font-size: 1.2rem;
            color: #333;
        }

        .text-muted {
            font-size: 0.9rem;
            color: #777;
        }

        hr {
            margin: 20px 0;
            border-color: rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
