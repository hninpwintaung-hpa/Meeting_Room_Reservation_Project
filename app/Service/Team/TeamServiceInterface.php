<?php

namespace App\Service\Team;

interface TeamServiceInterface
{
    public function store($data);
    public function update($data, $id);
    public function delete($id);
}
