<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'seance_id',
        'seat_row',
        'seat_number',
        'user_id',
        'qr_code',
    ];

    public function seance()
    {
        return $this->belongsTo(Seance::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
