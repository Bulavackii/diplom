@extends('layouts.admin')

@section('content')
    <div class="container mt-5" style="max-width: 850px;">
        <div class="card shadow-lg">
            <div class="card-header bg-dark text-white text-center">
                <h2 class="mb-0">Администраторы и Гости</h2>
                <p class="mt-2">Администраторов: {{ $admins->count() }} | Гостей: {{ $guests->count() }}</p>
            </div>
            <div class="card-body">
                <!-- Поиск пользователей -->
                <form action="{{ route('admin.users') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control search-input" placeholder="Поиск пользователей" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-outline-light search-btn">🔍</button>
                    </div>
                </form>

                <div class="row mt-4">
                    <!-- Администраторы -->
                    <div class="col-md-6">
                        <div class="card bg-primary text-white shadow-sm mb-4">
                            <div class="card-header text-center">
                                <i class="fas fa-user-shield"></i> Администраторы
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    @forelse ($admins as $admin)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $admin->name }}</strong> ({{ $admin->email }})
                                                <br>
                                                <small class="text-muted">Добавлен: {{ $admin->created_at->format('d.m.Y H:i') }}</small>
                                            </div>
                                            <form action="{{ route('admin.users.toggleRole', $admin->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-warning">
                                                    Сделать гостем
                                                </button>
                                            </form>
                                        </li>
                                    @empty
                                        <li class="list-group-item text-center">Нет администраторов</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Гости -->
                    <div class="col-md-6">
                        <div class="card bg-success text-white shadow-sm mb-4">
                            <div class="card-header text-center">
                                <i class="fas fa-user"></i> Гости
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    @forelse ($guests as $guest)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $guest->name }}</strong> ({{ $guest->email }})
                                                <br>
                                                <small class="text-muted">Добавлен: {{ $guest->created_at->format('d.m.Y H:i') }}</small>
                                            </div>
                                            <form action="{{ route('admin.users.toggleRole', $guest->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-warning">
                                                    Сделать админом
                                                </button>
                                            </form>
                                        </li>
                                    @empty
                                        <li class="list-group-item text-center">Нет гостей</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Пагинация -->
                <div class="d-flex justify-content-center">
                    {{ $admins->links() }}
                    {{ $guests->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Подключение FontAwesome --}}
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    {{-- Стили --}}
    <style>
        body {
            background-image: url('{{ asset('ad/i/background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .card {
            border-radius: 10px;
            overflow: hidden;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .search-input {
            border-radius: 25px 0 0 25px;
        }

        .search-btn {
            border-radius: 0 25px 25px 0;
            font-size: 1.1rem;
        }

        .list-group-item {
            background-color: #f8f9fa;
            font-size: 1rem;
            border: none;
            padding: 15px;
        }

        .btn {
            border-radius: 20px;
            padding: 8px 15px;
        }

        .btn-outline-warning {
            color: #000000;
            border-color: #ffc107;
        }

        .btn-outline-warning:hover {
            background-color: #f78504;
            color: #000;
        }

        .pagination {
            margin-top: 20px;
        }
    </style>
@endsection
