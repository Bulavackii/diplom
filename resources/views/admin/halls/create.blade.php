@extends('layouts.admin')

@section('content')
    <!-- Основной контейнер страницы -->
    <div class="container mt-5 d-flex justify-content-center">
        <div class="col-lg-8">
            <!-- Карточка с формой добавления зала -->
            <div class="card shadow-lg">
                <!-- Заголовок карточки -->
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="mb-0">Добавить Зал</h2>
                </div>
                <div class="card-body">
                    <!-- Блок для отображения ошибок валидации -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <!-- Кнопка для закрытия уведомления об ошибке -->
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Форма для добавления нового зала -->
                    <form action="{{ route('admin.halls.store') }}" method="POST">
                        @csrf <!-- Токен защиты от CSRF атак -->

                        <!-- Поле ввода для названия зала -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Название зала:</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>
                        </div>

                        <!-- Поле ввода для количества рядов -->
                        <div class="mb-3">
                            <label for="rows" class="form-label">Количество рядов:</label>
                            <input type="number" class="form-control" name="rows" id="rows" value="{{ old('rows') }}" min="1" required>
                        </div>

                        <!-- Поле ввода для количества мест в ряду -->
                        <div class="mb-3">
                            <label for="seats_per_row" class="form-label">Количество мест в ряду:</label>
                            <input type="number" class="form-control" name="seats_per_row" id="seats_per_row" value="{{ old('seats_per_row') }}" min="1" required>
                        </div>

                        <!-- Сообщение о создании мест -->
                        <div class="alert alert-info">
                            После создания зала все места будут автоматически добавлены с типом "Обычное". Вы сможете изменить типы мест в режиме редактирования зала.
                        </div>

                        <!-- Кнопки управления формой: отмена, очистить, добавить -->
                        <div class="text-center mt-4">
                            <a href="{{ route('admin.halls.index') }}" class="btn btn-secondary me-3">Отменить</a>
                            <button type="reset" class="btn btn-warning me-3">Очистить</button>
                            <button type="submit" class="btn btn-primary">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <!-- Подключение стилей -->
    <link rel="stylesheet" href="{{ asset('ad/css/index.css') }}">
@endpush

@push('scripts')
    <!-- Подключение Bootstrap для JavaScript функционала -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush