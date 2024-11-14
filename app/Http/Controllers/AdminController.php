<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use App\Models\Movie;
use App\Models\CinemaHall;
use App\Models\Seat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // Главная страница админки
    public function index()
    {
        // Получаем все сеансы с подгруженными данными о фильмах и залах
        $movieSessions = Seance::with('movie', 'cinemaHall')->orderBy('start_time', 'asc')->paginate(10);

        // Получаем количество администраторов и зрителей
        $adminsCount = User::where('role', 'admin')->count();
        $guestsCount = User::where('role', 'guest')->count();

        return view('admin.index', compact('movieSessions', 'adminsCount', 'guestsCount'));
    }

    // Управление фильмами
    public function movies()
    {
        // Получаем список фильмов с пагинацией
        $movies = Movie::paginate(10);
        return view('admin.movies.index', compact('movies'));
    }

    public function addMovieForm()
    {
        // Отображаем форму добавления фильма
        return view('admin.movies.create');
    }

    // Метод для сохранения нового фильма
    public function storeMovie(Request $request)
    {
        // Валидация данных фильма
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'country'     => 'required|string|max:255',
            'genre'       => 'required|string|max:255',
            'duration'    => 'required|integer|min:1|max:500',
            'poster'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Создание нового фильма
        $movie = new Movie($validated);

        // Проверка наличия постера и его сохранение
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('public/posters');
            $movie->poster_url = Storage::url($posterPath);
        }

        // Сохранение фильма
        $movie->save();

        return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно добавлен!');
    }

    // Метод для обновления существующего фильма
    public function updateMovie(Request $request, Movie $movie)
    {
        // Валидация данных фильма
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'country'     => 'required|string|max:255',
            'genre'       => 'required|string|max:255',
            'duration'    => 'required|integer|min:1|max:500',
            'poster'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Обновление данных фильма
        $movie->fill($validated);

        // Если загружен новый постер, удаляем старый и сохраняем новый
        if ($request->hasFile('poster')) {
            // Удаляем старый постер, если он существует
            if ($movie->poster_url) {
                $posterPath = str_replace('/storage/', 'public/', $movie->poster_url);
                if (Storage::exists($posterPath)) {
                    Storage::delete($posterPath);
                }
            }
            // Сохранение нового постера
            $posterPath = $request->file('poster')->store('public/posters');
            $movie->poster_url = Storage::url($posterPath);
        }

        // Сохранение обновленного фильма
        $movie->save();

        return redirect()->route('admin.movies.index')->with('success', 'Фильм успешно обновлён!');
    }

    // Управление пользователями
    public function users(Request $request)
    {
        // Поиск и фильтрация пользователей
        $searchTerm = $request->input('search');
        $adminsQuery = User::where('role', 'admin');
        $guestsQuery = User::where('role', 'guest');

        // Если есть запрос на поиск, фильтруем по имени или email
        if ($searchTerm) {
            $adminsQuery->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });

            $guestsQuery->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        // Получаем администраторов и гостей с пагинацией
        $admins = $adminsQuery->paginate(10);
        $guests = $guestsQuery->paginate(10);

        return view('admin.users', compact('admins', 'guests'));
    }

    // Переключение роли пользователя
    public function toggleRole(User $user)
    {
        // Переключаем роль пользователя между 'admin' и 'guest'
        $user->role = $user->isAdmin() ? 'guest' : 'admin';

        // Сохраняем обновленную роль
        $user->save();

        return redirect()->route('admin.users')->with('status', 'Роль пользователя успешно изменена.');
    }

    // Управление залами
    public function halls()
    {
        // Получаем список залов с пагинацией
        $cinemaHalls = CinemaHall::paginate(10);
        return view('admin.halls.index', compact('cinemaHalls'));
    }

    public function createHallForm()
    {
        // Отображаем форму для создания нового зала
        return view('admin.halls.create');
    }

    public function storeHall(Request $request)
    {
        // Валидация данных зала
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'rows'          => 'required|integer|min:1',
            'seats_per_row' => 'required|integer|min:1',
        ]);

        // Создание нового зала
        $cinemaHall = CinemaHall::create($validated);

        // Генерация мест с типом 'regular' по умолчанию
        for ($row = 1; $row <= $cinemaHall->rows; $row++) {
            for ($number = 1; $number <= $cinemaHall->seats_per_row; $number++) {
                Seat::create([
                    'cinema_hall_id' => $cinemaHall->id,
                    'row'            => $row,
                    'number'         => $number,
                    'seat_type'      => 'regular', // По умолчанию обычные места
                ]);
            }
        }

        return redirect()->route('admin.halls.index')->with('success', 'Зал успешно создан!');
    }

    public function generateSeatsForHall(CinemaHall $hall)
    {
        // Проверяем, есть ли уже места для зала
        if ($hall->seats()->exists()) {
            return redirect()->back()->with('warning', 'Для этого зала места уже существуют.');
        }

        // Генерируем места
        for ($row = 1; $row <= $hall->rows; $row++) {
            for ($number = 1; $number <= $hall->seats_per_row; $number++) {
                Seat::create([
                    'cinema_hall_id' => $hall->id,
                    'row'            => $row,
                    'number'         => $number,
                    'seat_type'      => 'regular', // По умолчанию обычные места
                ]);
            }
        }

        return redirect()->back()->with('success', 'Места для зала успешно сгенерированы.');
    }

    public function editHallForm(CinemaHall $hall)
    {
        // Получаем места зала и передаём их в представление
        $seats = $hall->seats()->orderBy('row')->orderBy('number')->get();

        return view('admin.halls.edit', compact('hall', 'seats'));
    }

    public function updateHall(Request $request, CinemaHall $hall)
    {
        // Валидация данных зала
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'rows'          => 'required|integer|min:1',
            'seats_per_row' => 'required|integer|min:1',
            'seats'         => 'required|array',
            'seats.*.id'    => 'required|exists:seats,id',
            'seats.*.seat_type' => 'required|in:regular,vip,none',
        ]);

        // Обновление данных зала
        $hall->update([
            'name'          => $validated['name'],
            'rows'          => $validated['rows'],
            'seats_per_row' => $validated['seats_per_row'],
        ]);

        // Обновление типов мест
        foreach ($validated['seats'] as $seatData) {
            $seat = Seat::find($seatData['id']);
            $seat->seat_type = $seatData['seat_type'];
            $seat->save();
        }

        return redirect()->route('admin.halls.index')->with('success', 'Зал успешно обновлён.');
    }

    public function toggleHallActivation(CinemaHall $hall)
    {
        // Переключаем статус активации зала
        $hall->is_active = !$hall->is_active;
        $hall->save();

        // Сообщение об активации/деактивации зала
        $status = $hall->is_active ? 'активирован' : 'деактивирован';
        return redirect()->route('admin.halls.index')->with('status', "Зал успешно {$status}");
    }

    // Удаление зала
    public function destroyHall(CinemaHall $hall)
    {
        // Проверяем, есть ли связанные сеансы с этим залом
        if ($hall->seances()->exists()) {
            return redirect()->route('admin.halls.index')->with('error', 'Невозможно удалить зал, так как с ним связаны сеансы.');
        }

        // Удаление всех мест в зале
        $hall->seats()->delete();

        // Удаление самого зала
        $hall->delete();

        return redirect()->route('admin.halls.index')->with('success', 'Зал успешно удалён!');
    }

    // Управление сеансами
    public function movieSessions()
    {
        // Получаем сеансы с подгруженными фильмами и залами
        $seances = Seance::with(['movie', 'cinemaHall'])->orderBy('start_time', 'asc')->paginate(10);
        return view('admin.seances.index', compact('seances'));
    }

    public function addMovieSessionForm()
    {
        // Отображаем форму для добавления сеанса
        $movies = Movie::all();
        $cinemaHalls = CinemaHall::all();
        return view('admin.seances.create', compact('movies', 'cinemaHalls'));
    }

    public function storeMovieSession(Request $request)
    {
        // Валидация данных сеанса
        $validated = $request->validate([
            'cinema_hall_id' => 'required|exists:cinema_halls,id',
            'movie_id'       => 'required|exists:movies,id',
            'start_time'     => 'required|date|after:now',
            'price_regular'  => 'required|numeric|min:0|max:10000',
            'price_vip'      => 'required|numeric|min:0|max:20000',
        ]);

        // Создание нового сеанса
        Seance::create($validated);

        return redirect()->route('admin.seances.index')->with('success', 'Сеанс успешно создан!');
    }

    public function editMovieSessionForm(Seance $movieSession)
    {
        // Отображаем форму для редактирования сеанса
        $movies = Movie::all();
        $cinemaHalls = CinemaHall::all();
        return view('admin.seances.edit', compact('movieSession', 'movies', 'cinemaHalls'));
    }

    public function updateMovieSession(Request $request, Seance $movieSession)
    {
        // Валидация данных сеанса
        $validated = $request->validate([
            'cinema_hall_id' => 'required|exists:cinema_halls,id',
            'movie_id'       => 'required|exists:movies,id',
            'start_time'     => 'required|date|after:now',
            'price_regular'  => 'required|numeric|min:0|max:10000',
            'price_vip'      => 'required|numeric|min:0|max:20000',
        ]);

        // Обновление данных сеанса
        $movieSession->update($validated);

        return redirect()->route('admin.seances.index')->with('success', 'Сеанс успешно обновлён!');
    }

    public function deleteMovieSession(Seance $movieSession)
    {
        // Удаление сеанса
        $movieSession->delete();
        return redirect()->route('admin.seances.index')->with('success', 'Сеанс успешно удалён!');
    }
}
