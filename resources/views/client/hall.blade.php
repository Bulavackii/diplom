@extends('layouts.client')

@section('title', 'Выбор мест')

@section('content')
    <div class="container mt-4 mb-5"> <!-- Добавлен нижний отступ (mb-5) -->
        <!-- Постер фильма -->
        <div class="text-center">
            <img src="{{ asset($session->movie->poster_url) }}" alt="Постер фильма {{ $session->movie->title }}" class="img-fluid" style="max-width: 300px; border-radius: 10px;">
        </div>

        <h2 class="text-center text-dark mt-3">Выберите места для сеанса "{{ $session->movie->title }}"</h2>
        <p class="text-center text-dark">Зал: {{ $session->cinemaHall->name }}</p>
        <p class="text-center text-dark">Время: {{ $session->start_time->format('d.m.Y H:i') }}</p>

        <!-- Картинка экрана кинотеатра -->
        <div class="screen-container text-center my-4">
            <img src="{{ asset('client/i/screen.png') }}" alt="Экран кинотеатра" class="img-fluid" style="max-width: 1000px;">
        </div>

        <!-- Отображение схемы зала -->
        <h3 class="text-center text-dark mt-5">Схема зала</h3>

        <!-- Сообщение об ошибке -->
        <div id="error-message" class="alert alert-danger d-none text-center" role="alert">
            Пожалуйста, выберите хотя бы одно место для бронирования.
        </div>

        <!-- Счетчик выбранных мест -->
        <p id="seat-counter" class="text-center text-dark">Вы выбрали <span id="selectedCount">0</span> мест.</p>

        <!-- Схема зала -->
        <div class="hall-layout mt-3 d-flex justify-content-center">
            <div class="seating-grid">
                @for ($row = 1; $row <= $rows; $row++)
                    <div class="row d-flex justify-content-center mb-2">
                        <span class="row-label text-dark font-weight-bold mr-3">Ряд {{ $row }}</span>
                        @for ($seat = 1; $seat <= $seatsPerRow; $seat++)
                            @php
                                $isBooked = $bookedSeats->contains(function ($seatObj) use ($row, $seat) {
                                    return $seatObj->seat_row == $row && $seatObj->seat_number == $seat;
                                });
                            @endphp

                            <label class="seat ml-2">
                                <input type="checkbox" name="seats[]" value="{{ $row }}-{{ $seat }}" {{ $isBooked ? 'disabled' : '' }} onclick="updateSelectedCount()">
                                <span class="{{ $isBooked ? 'booked' : 'available' }}">
                                    <strong>{{ $seat }}</strong>
                                </span>
                            </label>
                        @endfor
                    </div>
                @endfor
            </div>
        </div>

        <!-- Форма для бронирования -->
        <form id="bookingForm" action="{{ route('client.complete_booking') }}" method="POST" class="text-center mt-5">
            @csrf
            <input type="hidden" name="session_id" value="{{ $session->id }}">
            <input type="hidden" name="selected_seats" id="selectedSeatsInput">
            <button type="button" class="btn btn-warning btn-lg" onclick="completeBooking()">Забронировать выбранные места</button>
        </form>
    </div>

    @push('styles')
    <style>
        body {
            background-image: url('{{ asset('client/i/background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .hall-layout {
            max-width: 800px;
            margin: 0 auto; /* Центрирование схемы зала */
        }

        .seating-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(40px, 1fr));
            gap: 10px;
            justify-content: center; /* Центрирование содержимого сетки */
        }

        .row {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .row-label {
            width: 100px;
            text-align: right;
            margin-right: 15px;
        }

        .seat {
            position: relative;
        }

        .seat input[type="checkbox"] {
            display: none;
        }

        .seat span {
            display: inline-block;
            padding: 10px 14px;
            margin: 2px;
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
            text-align: center;
        }

        .seat span.booked {
            background-color: #f44336;
            cursor: not-allowed;
        }

        .seat span.available:hover {
            background-color: #388e3c;
        }

        .seat input[type="checkbox"]:checked + span {
            background-color: #ff9800;
        }

        .btn-warning {
            background-color: #ff9800;
            border-radius: 20px;
            padding: 10px 30px;
            transition: background-color 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #e68900;
        }

        .screen-container {
            margin-bottom: 40px;
        }
    </style>
    @endpush

    <script>
        // Функция для завершения бронирования
        function completeBooking() {
            const selectedSeats = document.querySelectorAll('input[name="seats[]"]:checked');
            if (selectedSeats.length === 0) {
                alert('Пожалуйста, выберите хотя бы одно место для бронирования.');
                return;
            }

            let selectedSeatsValue = [];
            selectedSeats.forEach(seat => {
                selectedSeatsValue.push(seat.value);
            });

            document.getElementById('selectedSeatsInput').value = selectedSeatsValue.join(',');

            // Отправляем форму бронирования
            const bookingForm = document.getElementById('bookingForm');
            bookingForm.submit();
        }

        // Функция для обновления счётчика выбранных мест
        function updateSelectedCount() {
            const selectedSeats = document.querySelectorAll('input[name="seats[]"]:checked');
            document.getElementById('selectedCount').innerText = selectedSeats.length;
        }

        // Инициализация счётчика при загрузке страницы
        document.addEventListener('DOMContentLoaded', function() {
            updateSelectedCount();
        });
    </script>
@endsection
