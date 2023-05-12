<?php

namespace App\Service\Reservation;

interface ReservationServiceInterface
{
    public function store($data);
    public function update($data, $id);
    public function delete($id);
}
