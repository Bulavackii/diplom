@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-dark text-white text-center">
                <h2 class="mb-0">Управление залами</h2>
            </div>
            <div class="card-body">
                <div class="actions mb-3 d-flex justify-content-between">
                    <a href="{{ route('admin.halls.create') }}" class="btn btn-success">Добавить новый зал</a>
                </div>

                <table class="table table-striped table-bordered table-hover">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Название зала</th>
                            <th>Количество рядов</th>
                            <th>Количество мест в ряду</th>
                            <th>Активный</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cinemaHalls as $hall)
                            <tr class="text-center align-middle">
                                <td>{{ $hall->name }}</td>
                                <td>{{ $hall->rows }}</td>
                                <td>{{ $hall->seats_per_row }}</td>
                                <td>
                                    <span class="badge {{ $hall->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $hall->is_active ? 'Да' : 'Нет' }}
                                    </span>
                                </td>
                                <td class="d-flex justify-content-center align-items-center">
                                    <!-- Кнопка для редактирования -->
                                    <a href="{{ route('admin.halls.edit', $hall->id) }}" class="btn btn-primary btn-sm me-2">
                                        Редактировать
                                    </a>
                
                                    <!-- Форма для активации/деактивации зала -->
                                    <form action="{{ route('admin.halls.toggle', $hall->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $hall->is_active ? 'btn-danger' : 'btn-success' }}">
                                            {{ $hall->is_active ? 'Остановить продажу билетов' : 'Активировать продажу билетов' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        body {
            background-image: url('{{ asset('ad/i/background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        /* Таблица */
        table {
            background-color: #fff;
        }
        thead {
            background-color: #343a40;
            color: white;
        }

        /* Выделение строк при наведении */
        table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Стиль для кнопок */
        .btn {
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover, .btn-success:hover, .btn-danger:hover, .btn-secondary:hover {
            transform: translateY(-3px);
        }

        /* Закругление таблицы */
        .table {
            border-radius: 15px;
            overflow: hidden;
            border: none;
        }

        /* Стили для заголовка */
        .card-header {
            background-color: #343a40;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Стили для бейджа */
        .badge {
            padding: 10px 15px;
            font-size: 1rem;
            border-radius: 15px;
        }

        /* Центрирование содержимого */
        td, th {
            vertical-align: middle;
        }

        .actions a {
            border-radius: 15px;
            padding: 10px 20px;
        }
    </style>
@endsection
