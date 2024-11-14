@extends('layouts.client')

@section('title', 'Ваш билет')

@section('content')
    <div class="container mt-5 mb-5"> <!-- Добавили класс mb-5 для отступа снизу -->
        <div class="ticket-wrapper">
            <div class="ticket">
                <!-- Заголовок билета -->
                <div class="ticket-header text-center">
                    <h2 class="ticket-title">Ваш билет</h2>
                </div>

                <!-- Информация о билете -->
                <div class="ticket-body">
                    <!-- Информация о фильме и сеансе -->
                    <div class="movie-info">
                        <p><strong>Фильм:</strong> {{ $session->movie->title }}</p>
                        <p><strong>Зал:</strong> {{ $session->cinemaHall->name }}</p>
                        <p><strong>Время сеанса:</strong> {{ $session->start_time->format('H:i, d.m.Y') }}</p>
                    </div>

                    <!-- Информация о местах -->
                    <div class="seats-info">
                        <p><strong>Места:</strong></p>
                        <ul>
                            @foreach ($tickets as $ticket)
                                <li>
                                    Ряд {{ $ticket->seat_row }}, Место {{ $ticket->seat_number }} ({{ $ticket->seat_type === 'vip' ? 'VIP' : 'Обычное' }})
                                    - {{ $ticket->price }} руб.
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Код бронирования -->
                    <div class="booking-code">
                        <p><strong>Код бронирования:</strong> {{ $booking_code }}</p>
                    </div>

                    <!-- QR-коды билетов -->
                    <div class="qr-codes text-center">
                        @foreach ($tickets as $ticket)
                            <div class="qr-code-item">
                                <img src="{{ asset($ticket->qr_code) }}" alt="QR-код билета">
                                <p>Ряд {{ $ticket->seat_row }}, Место {{ $ticket->seat_number }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Подпись -->
                <div class="ticket-footer text-center">
                    <p>Спасибо за покупку! Желаем приятного просмотра!</p>
                </div>
            </div>

            <!-- Кнопка для печати билета -->
            <div class="print-button text-center mt-4">
                <button class="btn btn-primary" onclick="window.print()">Печать билета</button>
            </div>
        </div>
    </div> <!-- Закрытие контейнера с классом mb-5 -->

    @push('styles')
        <!-- Стили для билета -->
        <style>
            .ticket-wrapper {
                max-width: 800px;
                margin: 0 auto;
                background-color: #f8f9fa;
                padding: 20px;
                border: 1px solid #dee2e6;
                border-radius: 8px;
                margin-bottom: 20px; /* Добавили отступ снизу */
            }

            .ticket {
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
            }

            .ticket-header {
                border-bottom: 2px solid #343a40;
                padding-bottom: 10px;
                margin-bottom: 20px;
            }

            .ticket-title {
                font-size: 2rem;
                color: #343a40;
            }

            .ticket-body p,
            .ticket-body ul {
                font-size: 1.1rem;
                margin-bottom: 10px;
            }

            .ticket-body ul {
                list-style-type: none;
                padding-left: 0;
            }

            .ticket-body li {
                margin-bottom: 5px;
            }

            .booking-code {
                margin-top: 20px;
                font-size: 1.2rem;
            }

            .qr-codes {
                margin-top: 30px;
            }

            .qr-code-item {
                display: inline-block;
                margin: 10px;
                text-align: center;
            }

            .qr-code-item img {
                width: 150px;
                height: 150px;
            }

            .ticket-footer {
                border-top: 2px solid #343a40;
                padding-top: 10px;
                margin-top: 20px;
            }

            .print-button {
                margin-top: 20px;
            }

            /* Стили для печати */
            @media print {
                body * {
                    visibility: hidden;
                }
                .ticket,
                .ticket * {
                    visibility: visible;
                }
                .ticket-wrapper {
                    border: none;
                    margin: 0;
                    padding: 0;
                }
                .print-button {
                    display: none;
                }
                .ticket {
                    box-shadow: none;
                    border: none;
                }
            }
        </style>
    @endpush
@endsection
