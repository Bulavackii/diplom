<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use App\Models\Ticket;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class ClientController extends Controller
{
    // Главная страница с расписанием фильмов
    public function index()
    {
        $sessions = Seance::with(['movie', 'cinemaHall'])
                          ->where('start_time', '>=', now())
                          ->orderBy('start_time', 'asc')
                          ->get();

        // Группируем сеансы по фильму
        $movies = $sessions->groupBy('movie_id');

        return view('client.index', compact('movies'));
    }

    // Страница выбора зала для фильма
    public function hall($id)
    {
        $session = Seance::with(['movie', 'cinemaHall'])
            ->whereHas('cinemaHall', function ($query) {
                $query->where('is_active', true);
            })
            ->findOrFail($id);

        $rows = $session->cinemaHall->rows;
        $seatsPerRow = $session->cinemaHall->seats_per_row;
        $bookedSeats = Ticket::where('seance_id', $session->id)->get(['seat_row', 'seat_number']);

        return view('client.hall', compact('session', 'rows', 'seatsPerRow', 'bookedSeats'));
    }

    // Обработка завершения бронирования
    public function completeBooking(Request $request)
    {
        $validatedData = $request->validate([
            'session_id' => 'required|integer|exists:seances,id',
            'selected_seats' => 'required|string',
        ]);

        $sessionId = $validatedData['session_id'];
        $selectedSeats = explode(',', $validatedData['selected_seats']);
        $session = Seance::with(['movie', 'cinemaHall'])->findOrFail($sessionId);
        $user = Auth::user(); // Используем Auth::user()

        // Логирование
        Log::info("Получены данные: session_id = $sessionId, selected_seats = " . implode(', ', $selectedSeats));

        // Подготовка информации о бронированных местах и QR-коде
        $bookingCode = strtoupper(Str::random(8)) . "-S{$sessionId}";
        $qrCodeContent = "Сеанс: {$session->movie->title}, Зал: {$session->cinemaHall->name}, Время: {$session->start_time->format('d.m.Y H:i')}\nМеста: ";
        $bookedSeatsInfo = [];

        foreach ($selectedSeats as $seatStr) {
            list($seatRow, $seatNumber) = explode('-', $seatStr);

            // Проверка на наличие бронирования
            if (Ticket::where('seance_id', $sessionId)->where('seat_row', $seatRow)->where('seat_number', $seatNumber)->exists()) {
                return back()->withErrors(['seat' => "Место ряд {$seatRow}, номер {$seatNumber} уже занято."]);
            }

            // Добавляем информацию о месте в QR-код
            $qrCodeContent .= "Ряд {$seatRow}, Место {$seatNumber}; ";
            $bookedSeatsInfo[] = [
                'seance_id' => $sessionId,
                'seat_row' => $seatRow,
                'seat_number' => $seatNumber,
                'user_id' => $user->id,
                'qr_code' => '', // QR-код будет общий
            ];
        }

        // Генерация и сохранение QR-кода
        $qrCodePath = public_path('qrcodes/' . $bookingCode . '.png');
        if (!file_exists(public_path('qrcodes'))) {
            mkdir(public_path('qrcodes'), 0755, true);
        }

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($qrCodeContent)
            ->size(300)
            ->margin(10)
            ->build();
        $result->saveToFile($qrCodePath);

        // Сохранение информации о каждом билете
        foreach ($bookedSeatsInfo as $seatInfo) {
            Ticket::create([
                'seance_id' => $seatInfo['seance_id'],
                'seat_row' => $seatInfo['seat_row'],
                'seat_number' => $seatInfo['seat_number'],
                'user_id' => $seatInfo['user_id'],
                'qr_code' => 'qrcodes/' . $bookingCode . '.png',
            ]);
        }

        return view('client.ticket', [
            'session' => $session,
            'seats' => $bookedSeatsInfo,
            'booking_code' => $bookingCode,
            'qrCodeUrl' => asset('qrcodes/' . $bookingCode . '.png'),
        ]);
    }

    // Страница с деталями фильма
    public function showMovieDetails($id)
    {
        $movie = Movie::findOrFail($id);
        return view('client.movie.details', compact('movie'));
    }

    // Метод для отображения списка фильмов
    public function showMovies()
    {
        $movies = Movie::all();
        return view('client.movies', compact('movies'));
    }

    // Страница с расписанием сеансов
    public function showSchedule()
    {
        $seances = Seance::with('movie', 'cinemaHall')->get();
        return view('client.schedule', compact('seances'));
    }

    // Страница "Контакты"
    public function showContactPage()
    {
        return view('client.contact');
    }

    // Страница профиля пользователя
    public function profile()
    {
        $user = Auth::user(); // Используем Auth::user()
        return view('client.profile', compact('user'));
    }

    // Страница с билетами пользователя
    public function tickets()
    {
        $user = Auth::user(); // Используем Auth::user()
        $tickets = $user->tickets()->with('seance.movie', 'seance.cinemaHall')->get();

        return view('client.tickets', compact('tickets'));
    }

    public function settings()
{
    $user = Auth::user();
    return view('client.settings', compact('user'));
}
}
