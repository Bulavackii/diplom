@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Добавить новую цену</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.prices.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="movie_session_id" class="form-label">Сеанс:</label>
                <select name="movie_session_id" id="movie_session_id" class="form-select" required>
                    <option value="">Выберите сеанс</option>
                    @foreach($movieSessions as $session)
                        <option value="{{ $session->id }}" {{ old('movie_session_id') == $session->id ? 'selected' : '' }}>
                            {{ $session->movie->title }} - {{ \Carbon\Carbon::parse($session->start_time)->format('d.m.Y H:i') }} (Зал: {{ $session->cinemaHall->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="cinema_hall_id" class="form-label">Зал:</label>
                <select name="cinema_hall_id" id="cinema_hall_id" class="form-select" required>
                    <option value="">Выберите зал</option>
                    @foreach($cinemaHalls as $hall)
                        <option value="{{ $hall->id }}" {{ old('cinema_hall_id') == $hall->id ? 'selected' : '' }}>
                            {{ $hall->name }} ({{ $hall->is_active ? 'Активен' : 'Неактивен' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="seat_type" class="form-label">Тип места:</label>
                <select name="seat_type" id="seat_type" class="form-select" required>
                    <option value="">Выберите тип</option>
                    <option value="standard" {{ old('seat_type') == 'standard' ? 'selected' : '' }}>Стандарт</option>
                    <option value="vip" {{ old('seat_type') == 'vip' ? 'selected' : '' }}>VIP</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Цена:</label>
                <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" id="price" step="0.01" required value="{{ old('price') }}">
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Добавить цену</button>
            <a href="{{ route('admin.prices.index') }}" class="btn btn-secondary ms-2">Отмена</a>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Пример клиентской валидации для проверки корректности заполнения формы
        document.getElementById('movie_session_id').addEventListener('change', function() {
            let sessionId = this.value;
            if (sessionId) {
                // Динамически изменяем доступные залы в зависимости от выбранного сеанса
                // Здесь может быть логика для фильтрации доступных залов
            }
        });
    });
</script>
@endpush