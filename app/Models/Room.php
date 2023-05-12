<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'room_name', 'room_image', 'capacity'];
    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'room_reservations', 'room_id', 'reservation_id')->withTimestamps();
    }
}
