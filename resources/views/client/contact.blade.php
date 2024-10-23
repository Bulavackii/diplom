@extends('layouts.client')

@section('title', 'Контакты')

@section('header')
    <div class="section-title text-center" style="margin-bottom: 5px;">
        Контакты
    </div>
@endsection

@section('content')
    <div class="container mt-4 mb-5"> <!-- Добавлен отступ снизу через mb-5 -->
        <div class="row justify-content-center">
            <div class="col-md-6"> <!-- Уменьшена ширина до col-md-6 -->
                <div class="card shadow-lg">
                    <div class="card-body">
                        <p>Если у вас есть вопросы, вы можете связаться с нами по следующим контактам:</p>
                        <ul>
                            <li><strong>Email:</strong> support@cinemaapp.com</li>
                            <li><strong>Телефон:</strong> +7 (123) 456-78-90</li>
                            <li><strong>Адрес:</strong> г. Москва, ул. Примерная, д. 1</li>
                        </ul>
                        <h5 class="mt-4">Свяжитесь с нами:</h5>
                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label">Ваше имя</label>
                                <input type="text" class="form-control" id="name" placeholder="Введите ваше имя">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Ваш email</label>
                                <input type="email" class="form-control" id="email" placeholder="Введите ваш email">
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Ваше сообщение</label>
                                <textarea class="form-control" id="message" rows="5" placeholder="Введите ваше сообщение"></textarea>
                            </div>
                            <div class="text-center"> <!-- Выравнивание кнопки по центру -->
                                <button type="submit" class="btn btn-primary">Отправить сообщение</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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

        .card {
            border-radius: 15px;
        }

        .btn-primary {
            background-color: #007bff;
            border-radius: 20px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Делаем форму уже */
        .col-md-6 {
            max-width: 500px; /* Ограничение максимальной ширины */
        }

        /* Центрирование кнопки */
        .text-center {
            text-align: center;
        }
    </style>
@endpush
