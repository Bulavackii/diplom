@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <!-- Карточка для управления залами -->
        <div class="card shadow-lg">
            <!-- Заголовок карточки -->
            <div class="card-header bg-dark text-white text-center">
                <h2 class="mb-0">Управление залами</h2>
            </div>
            <div class="card-body">
                <!-- Кнопка добавления нового зала -->
                <div class="actions mb-3 d-flex justify-content-between">
                    <a href="{{ route('admin.halls.create') }}" class="btn btn-success">Добавить</a>
                </div>

                <!-- Таблица с залами -->
                <table class="table table-striped table-bordered table-hover">
                    <!-- Заголовок таблицы -->
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
                    <!-- Вывод данных о залах -->
                    @foreach($cinemaHalls as $hall)
                        <tr class="text-center align-middle">
                            <!-- Название зала -->
                            <td>{{ $hall->name }}</td>
                            <!-- Количество рядов -->
                            <td>{{ $hall->rows }}</td>
                            <!-- Количество мест в ряду -->
                            <td>{{ $hall->seats_per_row }}</td>
                            <!-- Статус активности зала -->
                            <td>
                                    <span class="badge {{ $hall->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $hall->is_active ? 'Да' : 'Нет' }}
                                    </span>
                            </td>
                            <!-- Блок действий: редактирование, активация/деактивация, удаление -->
                            <td class="d-flex justify-content-center align-items-center">
                                <!-- Кнопка для редактирования зала -->
                                <a href="{{ route('admin.halls.edit', $hall->id) }}" class="btn btn-primary btn-sm me-2">
                                    Правка
                                </a>

                                <!-- Форма для активации/деактивации зала -->
                                <form action="{{ route('admin.halls.toggle', $hall->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $hall->is_active ? 'btn-danger' : 'btn-success' }} me-2">
                                        {{ $hall->is_active ? 'Стоп продажам' : 'Старт продажам' }}
                                    </button>
                                </form>

                                <!-- Форма для удаления зала -->
                                <form action="{{ route('admin.halls.destroy', $hall->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить этот зал?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!-- Пагинация -->
                <div class="d-flex justify-content-center">
                    {{ $cinemaHalls->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Подключение стилей -->
    @push('styles')
        <link rel="stylesheet" href="{{ asset('ad/css/index.css') }}">
        <!-- Подключение Font Awesome для иконок -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-Tg3I8dTybFlKhc+JwYxP5pXwX0YVj1xouq7Y3ZhxjvVzJZfDzq1Zg6I8+6Q0Dv7j2Q0HgZVb1gWXxFnuVPlOaA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @endpush
@endsection
