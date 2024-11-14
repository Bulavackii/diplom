<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seance;
use App\Models\Movie;
use App\Models\CinemaHall;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SeanceController extends Controller
{
    /**
     * Отображает список сеансов с пагинацией.
     */
    public function index()
    {
        // Получаем сеансы с их фильмами и залами, сортируем по времени начала
        $seances = Seance::with(['movie', 'cinemaHall'])
            ->orderBy('start_time', 'asc')
            ->paginate(10);

        // Передаем данные о сеансах в представление
        return view('admin.seances.index', compact('seances'));
    }

    /**
     * Показывает форму для создания нового сеанса.
     */
    public function create()
    {
        // Получаем все фильмы и залы для отображения в форме выбора
        $movies = Movie::all();
        $cinemaHalls = CinemaHall::all();

        // Передаем фильмы и залы в форму создания сеанса
        return view('admin.seances.create', compact('movies', 'cinemaHalls'));
    }

    /**
     * Сохраняет новый сеанс в базе данных.
     */
    public function store(Request $request)
    {
        // Валидация входных данных запроса
        $validated = $request->validate([
            'cinema_hall_id' => 'required|exists:cinema_halls,id',
            'movie_id'       => 'required|exists:movies,id',
            'start_time'     => 'required|date|after:now',
            'price_regular'  => 'required|numeric|min:0',
            'price_vip'      => 'required|numeric|min:0',
        ]);

        // Получаем данные о фильме
        $movie = Movie::findOrFail($validated['movie_id']);

        // Вычисляем время начала и окончания нового сеанса
        $startTime = Carbon::parse($validated['start_time']);
        $endTime   = $startTime->copy()->addMinutes($movie->duration);

        // Проверка на пересечение с существующими сеансами в этом зале
        $overlappingSeance = Seance::where('cinema_hall_id', $validated['cinema_hall_id'])
            ->join('movies', 'seances.movie_id', '=', 'movies.id')
            ->whereRaw(
                'julianday(seances.start_time) < julianday(?) AND 
                (julianday(seances.start_time) + movies.duration / 1440.0) > julianday(?)',
                [$endTime->format('Y-m-d H:i:s'), $startTime->format('Y-m-d H:i:s')]
            )
            ->exists();

        if ($overlappingSeance) {
            return back()->withErrors(['start_time' => 'В указанное время уже есть сеанс в этом зале.'])->withInput();
        }

        // Создаем новый сеанс без сохранения end_time в базе данных
        Seance::create([
            'cinema_hall_id' => $validated['cinema_hall_id'],
            'movie_id'       => $validated['movie_id'],
            'start_time'     => $startTime,
            'price_regular'  => $validated['price_regular'],
            'price_vip'      => $validated['price_vip'],
        ]);

        // Перенаправляем с сообщением об успехе
        return redirect()->route('admin.seances.index')->with('success', 'Сеанс успешно создан!');
    }

    /**
     * Показывает форму для редактирования сеанса.
     */
    public function edit(Seance $seance)
    {
        // Получаем все фильмы и залы для отображения в форме редактирования
        $movies = Movie::all();
        $cinemaHalls = CinemaHall::all();

        // Передаем данные сеанса, фильмов и залов в представление
        return view('admin.seances.edit', compact('seance', 'movies', 'cinemaHalls'));
    }

    /**
     * Обновляет сеанс в базе данных.
     */
    public function update(Request $request, Seance $seance)
    {
        // Валидация входных данных запроса
        $validated = $request->validate([
            'cinema_hall_id' => 'required|exists:cinema_halls,id',
            'movie_id'       => 'required|exists:movies,id',
            'start_time'     => 'required|date|after:now',
            'price_regular'  => 'required|numeric|min:0',
            'price_vip'      => 'required|numeric|min:0',
        ]);

        // Получаем данные о фильме
        $movie = Movie::findOrFail($validated['movie_id']);

        // Вычисляем новое время начала и окончания сеанса
        $startTime = Carbon::parse($validated['start_time']);
        $endTime   = $startTime->copy()->addMinutes($movie->duration);

        // Проверка на пересечение с существующими сеансами в этом зале
        $overlappingSeance = Seance::where('cinema_hall_id', $validated['cinema_hall_id'])
            ->where('seances.id', '!=', $seance->id)
            ->join('movies', 'seances.movie_id', '=', 'movies.id')
            ->whereRaw(
                'julianday(seances.start_time) < julianday(?) AND 
                (julianday(seances.start_time) + movies.duration / 1440.0) > julianday(?)',
                [$endTime->format('Y-m-d H:i:s'), $startTime->format('Y-m-d H:i:s')]
            )
            ->exists();

        if ($overlappingSeance) {
            return back()->withErrors(['start_time' => 'В указанное время уже есть сеанс в этом зале.'])->withInput();
        }

        // Обновляем сеанс без сохранения end_time в базе данных
        $seance->update([
            'cinema_hall_id' => $validated['cinema_hall_id'],
            'movie_id'       => $validated['movie_id'],
            'start_time'     => $startTime,
            'price_regular'  => $validated['price_regular'],
            'price_vip'      => $validated['price_vip'],
        ]);

        // Перенаправляем с сообщением об успехе
        return redirect()->route('admin.seances.index')->with('success', 'Сеанс успешно обновлён!');
    }

    /**
     * Удаляет сеанс из базы данных.
     */
    public function destroy(Seance $seance)
    {
        // Удаляем сеанс
        $seance->delete();

        // Перенаправляем с сообщением об успехе
        return redirect()->route('admin.seances.index')->with('success', 'Сеанс успешно удалён!');
    }
}
