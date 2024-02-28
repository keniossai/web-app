<?php

namespace App\Repositories;

use App\Models\Taxonomy;
use Illuminate\Support\Facades\DB;

class TaxonomiesRepositories
{
    public static function getTaxonomiesSpecials()
    {
        $taxonomies = DB::table('taxonomy')
                ->select(
                    'taxonomy.id_taxonomy',
                    'taxonomy.id_directory',
                    'taxonomy.id_guide',
                    'taxonomy.id_location',
                    'taxonomy.id_practice',
                    'taxonomy.deleted',
                )
                ->leftJoin('directory', function($join){
                    $join->on('taxonomy.id_directory', '=', 'directory.id_directory');
                })
                ->leftJoin('guide', function($join){
                    $join->on('taxonomy.id_guide', '=', 'guide.id_guide');
                })
                ->leftJoin('location', function($join){
                    $join->on('taxonomy.id_location', '=', 'location.id_location');
                })
                ->leftJoin('practice', function($join){
                    $join->on('taxonomy.id_practice', '=', 'practice.id_practice');
                })
                ->where(['taxonomy.deleted' => 0])
                ->orderByRaw('LEFT(directory.name, 1) asc')
                ->orderByRaw('LEFT(guide.name, 1) asc')
                ->orderByRaw('LEFT(location.name, 1) asc')
                ->orderByRaw('LEFT(practice.name, 1) asc')
                ->get();

        return $taxonomies->toJson();
    }
}
