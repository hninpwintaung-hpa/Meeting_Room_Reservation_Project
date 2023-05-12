<?php

namespace App\Repository\Reservation;

interface ReservationRepoInterface
{
    public function get();
    public function show($id);
}
