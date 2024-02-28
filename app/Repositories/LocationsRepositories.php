<?php

namespace App\Repositories;

use App\Models\Location;
use Illuminate\Support\Facades\DB;

class LocationsRepositories
{
    public static function getLocationsOnlyIds($idsLocation)
    {
        $result = DB::table('location')
            ->select(
                'id_location',
                'name',
            )
            ->where('deleted', 0)
            ->whereIn('id_location', $idsLocation)
            ->orderByRaw('LEFT(name, 2) asc')
            ->get();

            $result = $result->toArray();
            array_unshift($result, (object)['id_location' => '', 'name' => '']);

        return $result;
    }

    public static function getLocations()
    {
        $result = DB::table('location')
            ->select(
                'id_location',
                'name',
            )
            ->where('deleted', 0)
            ->orderByRaw('LEFT(name, 2) asc')
            ->get();

            $result = $result->toArray();
            array_unshift($result, (object)['id_location' => '', 'name' => '']);

        return $result;
    }
}
