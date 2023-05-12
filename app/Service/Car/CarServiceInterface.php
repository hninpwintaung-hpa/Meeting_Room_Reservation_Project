<?php

namespace App\Service\Car;

interface CarServiceInterface
{
    public function store($data);
    public function update($data, $id);
    public function delete($id);
}
