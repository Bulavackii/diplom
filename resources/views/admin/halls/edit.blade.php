@extends('layouts.admin')

@section('content')
    <!-- Основной контейнер страницы редактирования зала -->
    <div class="container mt-5">
        <h1 class="text-center mb-4">Редактировать Зал</h1>

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

        <!-- Форма для редактирования зала -->
        <form action="{{ route('admin.halls.update', $hall->id) }}" method="POST">
            @csrf <!-- Токен защиты от CSRF атак -->
            @method('PUT') <!-- Метод для обновления данных (PUT) -->

            <!-- Поля названия, количества рядов и мест в ряду -->
            <div class="mb-3">
                <label for="name" class="form-label">Название зала:</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $hall->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="rows" class="form-label">Количество рядов:</label>
                <input type="number" class="form-control" name="rows" id="rows" value="{{ old('rows', $hall->rows) }}" min="1" required>
            </div>

            <div class="mb-3">
                <label for="seats_per_row" class="form-label">Количество мест в ряду:</label>
                <input type="number" class="form-control" name="seats_per_row" id="seats_per_row" value="{{ old('seats_per_row', $hall->seats_per_row) }}" min="1" required>
            </div>

            <!-- Проверяем, есть ли места -->
            @if($seats->isEmpty())
                <div class="alert alert-warning">
                    Для этого зала ещё не созданы места. Нажмите кнопку ниже, чтобы сгенерировать места.
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('admin.halls.index') }}" class="btn btn-secondary me-3">Отменить</a>
                    <form action="{{ route('admin.halls.generate_seats', $hall->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary">Сгенерировать места</button>
                    </form>
                </div>
            @else
                <!-- Отображение мест -->
                <h3 class="mt-4">Конфигурация мест</h3>
                <div class="hall-layout mt-3">
                    @foreach($seats->groupBy('row') as $rowNumber => $seatsInRow)
                        <div class="seat-row d-flex mb-2 align-items-center">
                            <span class="row-label mr-3">Ряд {{ $rowNumber }}</span>
                            @foreach($seatsInRow as $seat)
                                <div class="seat m-1 text-center">
                                    <input type="hidden" name="seats[{{ $seat->id }}][id]" value="{{ $seat->id }}">
                                    <select name="seats[{{ $seat->id }}][seat_type]" class="form-select">
                                        <option value="regular" {{ $seat->seat_type == 'regular' ? 'selected' : '' }}>Обычное</option>
                                        <option value="vip" {{ $seat->seat_type == 'vip' ? 'selected' : '' }}>VIP</option>
                                        <option value="none" {{ $seat->seat_type == 'none' ? 'selected' : '' }}>Отсутствует</option>
                                    </select>
                                    <span class="seat-number">{{ $seat->number }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>

                <!-- Кнопки управления формой: отмена, сохранить -->
                <div class="text-center mt-4">
                    <a href="{{ route('admin.halls.index') }}" class="btn btn-secondary me-3">Отменить</a>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            @endif
        </form>
    </div>
@endsection

@push('styles')
    <!-- Подключение пользовательских стилей -->
    <link rel="stylesheet" href="{{ asset('ad/css/index.css') }}">
@endpush
