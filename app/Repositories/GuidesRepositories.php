<?php

namespace App\Repositories;

use App\Models\Guide;
use Illuminate\Support\Facades\DB;

class GuidesRepositories
{
    public static function getGuidesByDirectory($id_directory, $idsGuide)
    {
        $result = DB::table('guide')
            ->select(
                'id_directory',
                'id_guide',
                'name',
            )
            ->where(['deleted' => 0, 'id_directory' => $id_directory])
            ->whereIn('id_guide', $idsGuide)
            ->orderByRaw('LEFT(name, 2) asc')
            ->get();

            $result = $result->toArray();
            array_unshift($result, (object)['id_directory' => '', 'id_guide' => '', 'name' => '']);

        return $result;
    }

    public static function getGuides()
    {
        $result = DB::table('guide')
            ->select(
                'id_directory',
                'id_guide',
                'name',
            )
            ->where('deleted', 0)
            ->orderByRaw('LEFT(name, 2) asc')
            ->get();

            $result = $result->toArray();
            array_unshift($result, (object)['id_directory' => '', 'id_guide' => '', 'name' => '']);

        return $result;
    }
}
