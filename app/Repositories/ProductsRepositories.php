<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductsRepositories
{
    public static function getProducts()
    {
        $result = DB::table('product')
            ->select(
                'id_product',
                'name',
            )
            ->orderByRaw('LEFT(name, 2) asc')
            ->get();

            $result = $result->toArray();
            array_unshift($result, (object)['id_product' => '', 'name' => '']);

        return $result;
    }
}
