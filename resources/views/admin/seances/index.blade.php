@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4">Управление Сеансами</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <a href="{{ route('admin.seances.create') }}" class="btn btn-primary mb-4">Создать Новый Сеанс</a>

    @if($seances->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Фильм</th>
                        <th>Зал</th>
                        <th>Время Начала</th>
                        <th>Время Окончания</th>
                        <th>Цена (Регуляр)</th>
                        <th>Цена (VIP)</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($seances as $seance)
                        <tr>
                            <td>{{ $seance->id }}</td>
                            <td>{{ $seance->movie->title }}</td>
                            <td>{{ $seance->cinemaHall->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($seance->start_time)->format('d.m.Y H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($seance->end_time)->format('d.m.Y H:i') }}</td>
                            <td>{{ number_format($seance->price_regular, 2) }} руб.</td>
                            <td>{{ number_format($seance->price_vip, 2) }} руб.</td>
                            <td class="d-flex justify-content-center align-items-center">
                                <a href="{{ route('admin.seances.edit', $seance->id) }}" class="btn btn-sm btn-warning me-2" title="Редактировать">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.seances.destroy', $seance->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены, что хотите удалить этот сеанс?')" title="Удалить">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $seances->links() }}
        </div>
    @else
        <p class="text-center text-muted">Нет доступных сеансов для отображения.</p>
    @endif
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    /* Общие стили для страницы */
    body {
        background-image: url('{{ asset('ad/i/background.jpg') }}');
        background-size: cover;
        background-position: center;
    }

    /* Стили для таблицы */
    .table {
        border-collapse: separate;
        border-spacing: 0;
        background-color: rgba(255, 255, 255, 0.85); /* Полупрозрачный фон */
        border-radius: 15px;
        overflow: hidden;
    }

    thead {
        background-color: #343a40;
        color: white;
    }

    th, td {
        padding: 12px;
        text-align: center;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.1); /* Подсветка строки при наведении */
    }

    /* Кнопки */
    .btn-warning {
        background-color: #ffc107;
        border-radius: 20px;
        transition: background-color 0.3s;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .btn-danger {
        border-radius: 20px;
        background-color: #dc3545;
        transition: background-color 0.3s;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    /* Стили для пагинации */
    .pagination {
        justify-content: center;
    }

    .pagination .page-item .page-link {
        border-radius: 50%;
        padding: 8px 14px;
        color: #007bff;
        transition: background-color 0.3s;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }

    .pagination .page-item .page-link:hover {
        background-color: rgba(0, 123, 255, 0.1);
    }

</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
