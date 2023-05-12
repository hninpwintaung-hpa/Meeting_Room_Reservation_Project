<?php

namespace App\Service\Room;

interface RoomServiceInterface
{
    public function store($data);
    public function update($data, $id);
}
