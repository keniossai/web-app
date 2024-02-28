<?php

namespace App\Repositories;

use App\Models\Directory;
use Illuminate\Support\Facades\DB;

class DirectoriesRepositories
{
    public static function getCollDirectories()
    {
        return DB::table('directory')
            ->select(
                'id_directory',
                'name',
            )
            ->where('deleted', 0)
            ->orderByRaw('LEFT(name, 2) asc')
            ->get();
    }

    public static function getDirectories()
    {
        $result = DB::table('directory')
            ->select(
                'id_directory',
                'name',
            )
            ->where('deleted', 0)
            ->orderByRaw('LEFT(name, 2) asc')
            ->get();

            $result = $result->toArray();
            array_unshift($result, (object)['id_directory' => '', 'name' => '']);

        return $result;
    }
}
