<?php

namespace App\Service\Team;

use App\Models\Team;

class TeamService implements TeamServiceInterface
{
    public function store($data)
    {
        return Team::create($data);
    }
    public function update($data, $id)
    {
        $team = Team::where('id', $id)->first();
        return $team->update($data);
    }
    public function delete($id)
    {
        return Team::where('id', $id)->delete();
    }
}
