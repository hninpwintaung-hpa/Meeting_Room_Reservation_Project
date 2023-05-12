<?php

namespace App\Repository\Team;

use App\Models\Team;

class TeamRepository implements TeamRepoInterface
{
    public function get()
    {
        return Team::all();
    }
    public function show($id)
    {
        return Team::where('id', $id)->first();
    }
}
