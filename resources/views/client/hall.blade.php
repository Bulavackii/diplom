@extends('layouts.client')

@section('title', 'Выбор мест')

@section('content')
    <div class="container mt-4 mb-5">
        <!-- Постер фильма -->
        <div class="text-center">
            <img src="{{ asset($session->movie->poster_url) }}" alt="Постер фильма {{ $session->movie->title }}"
                 class="img-fluid" style="max-width: 300px; border-radius: 10px;">
        </div>

        <!-- Заголовок и информация о сеансе -->
        <h2 class="text-center text-dark mt-3">Выберите места для сеанса "{{ $session->movie->title }}"</h2>
        <p class="text-center text-dark">Зал: {{ $session->cinemaHall->name }}</p>
        <p class="text-center text-dark">Время: {{ $session->start_time->format('d.m.Y H:i') }}</p>

        <!-- Изображение экрана кинотеатра -->
        <div class="screen-container text-center my-4">
            <div class="screen">Экран</div>
        </div>

        <!-- Схема зала -->
        <h3 class="text-center text-dark mt-5">Схема зала</h3>

        <!-- Счетчик выбранных мест -->
        <p id="seat-counter" class="text-center text-dark">Вы выбрали <span id="selectedCount">0</span> мест.</p>

        <!-- Схема зала -->
        <div class="hall-layout mt-3 d-flex justify-content-center">
            <div class="seating-grid">
                @foreach ($seats->groupBy('row') as $rowNumber => $seatsInRow)
                    <div class="seat-row-container d-flex justify-content-center align-items-center mb-2">
                        <!-- Метка ряда -->
                        <span class="row-label text-dark font-weight-bold mr-3">Ряд {{ $rowNumber }}</span>
                        <div class="seats-row d-flex justify-content-center">
                            @foreach ($seatsInRow as $seat)
                                @php
                                    // Проверяем, забронировано ли место
                                    $isBooked = $bookedSeats->contains(function ($seatObj) use ($seat) {
                                        return $seatObj->seat_row == $seat->row && $seatObj->seat_number == $seat->number;
                                    });
                                @endphp

                                @if ($seat->seat_type !== 'none')
                                    <!-- Место -->
                                    <label class="seat m-1">
                                        <input type="checkbox" name="seats[]" value="{{ $seat->row }}-{{ $seat->number }}"
                                               {{ $isBooked ? 'disabled' : '' }} onclick="updateSelectedCount()">
                                        <span class="
                                            seat-number
                                            @if ($isBooked)
                                                booked
                                            @elseif ($seat->seat_type == 'vip')
                                                vip
                                            @else
                                                regular
                                            @endif
                                        " title="Ряд {{ $seat->row }}, Место {{ $seat->number }}">
                                            {{ $seat->number }}
                                        </span>
                                    </label>
                                @else
                                    <!-- Отсутствующее место -->
                                    <div class="seat m-1">
                                        <span class="seat-number none"></span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Форма бронирования -->
        <form id="bookingForm" action="{{ route('client.complete_booking') }}" method="POST" class="text-center mt-5">
            @csrf
            <input type="hidden" name="session_id" value="{{ $session->id }}">
            <input type="hidden" name="selected_seats" id="selectedSeatsInput">
            <button type="button" class="btn btn-warning btn-lg" onclick="completeBooking()">Забронировать</button>
        </form>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('client/css/index.css') }}">
        <style>
            .screen {
                width: 80%;
                height: 20px;
                background-color: #ccc;
                margin: 0 auto;
                border-radius: 5px;
                text-align: center;
                line-height: 20px;
                font-weight: bold;
            }
            .seat {
                position: relative;
            }
            .seat-number {
                display: inline-block;
                width: 40px;
                height: 40px;
                background-color: #28a745; /* Цвет по умолчанию для обычных мест */
                border-radius: 5px;
                text-align: center;
                line-height: 40px;
                font-weight: bold;
                color: #fff;
                cursor: pointer;
            }
            .seat-number.vip {
                background-color: #ffc107; /* Желтый для VIP мест */
            }
            .seat-number.booked {
                background-color: #dc3545; /* Красный для занятых мест */
                cursor: not-allowed;
            }
            .seat-number.none {
                background-color: #6c757d; /* Серый для отсутствующих мест */
                opacity: 0.5;
                cursor: default;
            }
            .seat input[type="checkbox"] {
                position: absolute;
                opacity: 0;
                cursor: pointer;
                width: 100%;
                height: 100%;
                margin: 0;
                left: 0;
                top: 0;
                z-index: 1;
            }
            .seat input[type="checkbox"]:checked + .seat-number {
                filter: brightness(0.7);
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Завершение бронирования
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

                document.getElementById('bookingForm').submit();
            }

            // Обновление счетчика выбранных мест
            function updateSelectedCount() {
                const selectedSeats = document.querySelectorAll('input[name="seats[]"]:checked');
                document.getElementById('selectedCount').innerText = selectedSeats.length;
            }

            // Инициализация
            document.addEventListener('DOMContentLoaded', function() {
                updateSelectedCount();
            });
        </script>
    @endpush
@endsection
