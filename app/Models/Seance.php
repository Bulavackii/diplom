<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Seance extends Model
{
    use HasFactory;

    // Указываем, что эта модель связана с таблицей 'seances'
    protected $table = 'seances';

    // Поля, которые могут быть массово заполнены
    protected $fillable = [
        'cinema_hall_id',  // ID кинозала
        'movie_id',        // ID фильма
        'start_time',      // Время начала сеанса
        'price_regular',   // Цена за обычное место
        'price_vip',       // Цена за VIP место
    ];

    // Преобразование полей в тип datetime
    protected $casts = [
        'start_time' => 'datetime',
    ];

    /**
     * Связь с фильмом.
     * Один сеанс принадлежит одному фильму.
     */
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * Связь с кинозалом.
     * Один сеанс проходит в одном кинозале.
     */
    public function cinemaHall()
    {
        return $this->belongsTo(CinemaHall::class);
    }

    /**
     * Связь с билетами.
     * Один сеанс может иметь множество билетов.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Форматирование времени начала сеанса.
     * Возвращает отформатированную строку даты и времени.
     */
    public function getFormattedStartTimeAttribute()
    {
        return $this->start_time ? $this->start_time->format('d.m.Y H:i') : null;
    }

    /**
     * Вычисление времени окончания сеанса на основе длительности фильма.
     */
    public function getEndTimeAttribute()
    {
        return $this->start_time ? $this->start_time->copy()->addMinutes($this->movie->duration) : null;
    }

    /**
     * Форматирование времени окончания сеанса.
     * Возвращает отформатированную строку даты и времени.
     */
    public function getFormattedEndTimeAttribute()
    {
        return $this->end_time ? $this->end_time->format('d.m.Y H:i') : null;
    }

    /**
     * Проверка доступности сеанса для бронирования.
     * Сеанс доступен, если он еще не завершился.
     */
    public function isAvailable()
    {
        return $this->end_time > now();
    }
}
