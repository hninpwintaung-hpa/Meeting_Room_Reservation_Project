<?php

namespace App\Repository\Reservation;

use App\Models\Reservation;

class ReservationRepository implements ReservationRepoInterface
{
    public function get()
    {
        return Reservation::all();
    }
    public function show($id)
    {
        return Reservation::where('id', $id)->first();
    }
}
