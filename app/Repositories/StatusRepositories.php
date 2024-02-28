<?php

namespace App\Repositories;

use App\Models\Status;
use Illuminate\Support\Facades\DB;

class StatusRepositories
{
    public static function getStatusForClient()
    {
        $result = DB::table('status')
            ->select(
                'id_status',
                'name'
            )
            ->where(['element_type' => 'task', 'status_type' => 'client', 'deleted' => 0])
            ->orderByRaw('LEFT(name, 2) asc')
            ->get();

            $result = $result->toArray();
            foreach ($result as &$row) {
                $row->name = __('babel.'.$row->name);
            }
            array_unshift($result, (object)['id_status' => '', 'name' => '']);

        return $result;
    }

    public static function getAllStatus()
    {
        $result = DB::table('status')
            ->select(
                'id_status',
                'name'
            )
            ->where(['element_type' => 'task', 'deleted' => 0])
            ->orderByRaw('LEFT(name, 2) asc')
            ->get();

            $result = $result->toArray();
            foreach ($result as &$row) {
                $row->name = __('babel.'.$row->name);
            }
            array_unshift($result, (object)['id_status' => '', 'name' => '']);

        return $result;
    }

    public static function getStatusConsultant()
    {
        $statusConsultant = DB::table('status')
            ->select(
                'id_status',
                'name',
                'description',
                'order'
            )
            ->where(['element_type' => 'task', 'status_type' => 'consultant', 'deleted' => 0])
            ->orderBy('order', 'asc')
            ->get();

        return $statusConsultant;
    }
}
