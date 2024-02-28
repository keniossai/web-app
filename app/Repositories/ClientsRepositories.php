<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Support\Facades\DB;

class ClientsRepositories
{
    public static function getCLientsOfProjects()
    {
        $ids_client = Project::where('deleted', 0)->pluck('id_client')->unique();

        $clients = DB::table('client')
            ->select('id_client', 'name')
            ->whereIn('id_client', $ids_client)
            ->get();

        return $clients;
    }

}
