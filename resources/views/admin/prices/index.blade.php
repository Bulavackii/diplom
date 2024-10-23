@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Список цен</h2>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <a href="{{ route('admin.prices.create') }}" class="btn btn-success mb-3">Добавить новую цену</a> <!-- Кнопка добавления -->

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Сеанс</th>
                        <th>Зал</th>
                        <th>Тип места</th>
                        <th>Цена</th>
                        <th class="text-center">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prices as $price)
                        <tr>
                            <td>{{ $price->movieSession->movie->title ?? 'Не указан' }} 
                                ({{ \Carbon\Carbon::parse($price->movieSession->start_time)->format('d.m.Y H:i') }})
                            </td>
                            <td>{{ $price->cinemaHall->name ?? 'Не указан' }}</td>
                            <td>{{ $price->seat_type == 'standard' ? 'Стандарт' : 'VIP' }}</td>
                            <td>{{ number_format($price->price, 2) }} руб.</td>
                            <td class="text-center">
                                <a href="{{ route('admin.prices.edit', $price->id) }}" class="btn btn-primary btn-sm">Редактировать</a>
                                <form action="{{ route('admin.prices.destroy', $price->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm delete-btn" onclick="return confirm('Вы уверены, что хотите удалить эту цену?')">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                if (!confirm('Вы уверены, что хотите удалить эту цену?')) {
                    event.preventDefault(); // Останавливаем отправку формы, если администратор отменил подтверждение
                }
            });
        });
    });
</script>
@endpush
