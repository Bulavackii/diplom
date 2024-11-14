<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = [
        'cinema_hall_id',
        'row',
        'number',
        'seat_type',
    ];

    // Связь с залом
    public function cinemaHall()
    {
        return $this->belongsTo(CinemaHall::class);
    }
}
