<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CarReservation extends Pivot
{
    use HasFactory;
    protected $fillable = ['reserve_id', 'car_id'];
}
