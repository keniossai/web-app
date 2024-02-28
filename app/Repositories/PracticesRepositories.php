<?php

namespace App\Repositories;

use App\Models\Practice;
use Illuminate\Support\Facades\DB;

class PracticesRepositories
{
    public static function getPractices()
    {
        $result = DB::table('practice')
            ->select(
                'id_directory',
                'id_practice',
                'name',
            )
            ->where('deleted', 0)
            ->orderByRaw('LEFT(name, 2) asc')
            ->get();

            $result = $result->toArray();
            array_unshift($result, (object)['id_directory' => '', 'id_practice' => '', 'name' => '']);

        return $result;
    }

    public static function getPracticesByDirectory($id_directory, $idsPractice)
    {
        $result = DB::table('practice')
            ->select(
                'id_directory',
                'id_practice',
                'name',
            )
            ->where(['deleted' => 0, 'id_directory' => $id_directory])
            ->whereIn('id_practice', $idsPractice)
            ->orderByRaw('LEFT(name, 2) asc')
            ->get();

            $result = $result->toArray();
            array_unshift($result, (object)['id_directory' => '', 'id_practice' => '', 'name' => '']);

        return $result;
    }
}
