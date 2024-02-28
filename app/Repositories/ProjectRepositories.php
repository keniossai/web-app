<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepositories
{
    public static function getProject($id_project)
    {
        return Project::find($id_project);
    }

    public static function getProjectByClient($id_client)
    {
        return Project::where([
            'id_client' => $id_client,
            'deleted' => 0
        ])->orderBy('year', 'DESC')->get();
    }
}
