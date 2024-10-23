@extends('layouts.client')

@section('title', 'Ваш билет')

@section('content')
    <div class="container mt-4">
        <section class="shadow-lg">
            <h2 class="text-center text-dark">Ваш билет</h2>

            <p><strong>Фильм:</strong> {{ $session->movie->title }}</p>
            <p><strong>Зал:</strong> {{ $session->cinemaHall->name }}</p>
            <p><strong>Время сеанса:</strong> {{ $session->start_time->translatedFormat('H:i, d F Y') }}</p>

            <!-- Перечисление всех выбранных мест -->
            <p><strong>Места:</strong></p>
            <ul class="list-unstyled">
                @foreach ($seats as $seat)
                    <li><strong>Ряд {{ $seat['seat_row'] }}, Место {{ $seat['seat_number'] }}</strong></li>
                @endforeach
            </ul>

            <p><strong>Код бронирования:</strong> {{ $booking_code }}</p>

            @if($qrCodeUrl)
                <div class="qr-code text-center">
                    <img src="{{ $qrCodeUrl }}" alt="QR-код билета" class="img-fluid">
                    <p class="text-dark">Покажите этот QR-код при входе</p>
                </div>
            @else
                <p class="text-danger">QR-код не был сгенерирован.</p>
            @endif

            <div class="text-center mt-4">
                <button class="btn btn-warning" onclick="window.print()">Печать билета</button>
            </div>
        </section>
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

        section {
            border: 2px dashed #333;
            padding: 30px;
            margin: 50px auto;
            border-radius: 12px;
            max-width: 600px;
            background-color: rgba(255, 255, 255, 0.9); /* Прозрачный фон */
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .qr-code {
            margin-top: 20px;
        }

        button {
            padding: 12px 30px;
            font-size: 1em;
            background-color: #ff9800;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #e68900;
        }

        p, strong {
            color: #333;
        }

    </style>
@endpush
