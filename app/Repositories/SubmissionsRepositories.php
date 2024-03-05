<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubmissionsRepositories
{
    public static function getTasks($id_project)
    {
        return DB::table('task')
            ->select(
                'task.id_task',
                'task.id_product',
                'task.id_directory',
                'task.id_guide',
                'task.id_location',
                'task.id_practice',
                'task.agreed_deadline',
                'task.deadline',
                'task.confirmed',
                DB::raw("GROUP_CONCAT(DISTINCT COALESCE(contact_rel.id_contact, '')) as ids_contact"),
                DB::raw("REPLACE(GROUP_CONCAT(COALESCE(CONCAT(contact.name, ' ', contact.last_name), '')), ',', ', ') as contact_names"),
                DB::raw('(
                    SELECT status.id_status
                    FROM status_history
                    LEFT JOIN status ON status_history.id_status = status.id_status
                    WHERE status_history.element_id = task.id_task
                    AND status_history.active = 1
                    AND status.element_type = "task"
                    AND status.status_type = "client"
                    ORDER BY status_history.created_at DESC
                    LIMIT 1
                ) as id_status'),
                 DB::raw('(
                    SELECT status_history.description
                    FROM status_history
                    LEFT JOIN status ON status_history.id_status = status.id_status
                    WHERE status_history.element_id = task.id_task
                    AND status_history.active = 1
                    AND status.element_type = "task"
                    AND status.status_type = "client"
                    ORDER BY status_history.created_at DESC
                    LIMIT 1
                ) as description'),
            )
            ->leftJoin('project', function($join){
                $join->on('task.id_project', '=', 'project.id_project');
            })
            ->leftJoin('directory', function($join){
                $join->on('task.id_directory', '=', 'directory.id_directory');
            })
            ->leftJoin('guide', function($join){
                $join->on('task.id_guide', '=', 'guide.id_guide');
            })
            ->leftJoin('location', function($join){
                $join->on('task.id_location', '=', 'location.id_location');
            })
            ->leftJoin('practice', function($join){
                $join->on('task.id_practice', '=', 'practice.id_practice');
            })
            ->leftJoin('contact_rel', function($join){
                $join->on('task.id_task', '=', 'contact_rel.element_id')->where([
                    'contact_rel.type_element' => 'task',
                    'contact_rel.type_rel' => 'marketing_business_development',
                    'contact_rel.deleted' => 0
                ]);
            })
            ->leftJoin('contact', function($join){
                $join->on('contact_rel.id_contact', '=', 'contact.id_contact');
            })
            ->where(['task.id_project' => $id_project, 'task.deleted' => 0])
            ->orderByRaw('LEFT(directory.name, 1) asc')
            ->orderByRaw('LEFT(guide.name, 1) asc')
            ->orderByRaw('LEFT(location.name, 1) asc')
            ->orderByRaw('LEFT(practice.name, 1) asc')
            ->groupBy((['task.id_task', 'task.id_product', 'task.id_directory', 'task.id_guide', 'task.id_location', 'task.id_practice', 'task.agreed_deadline', 'task.deadline', 'task.confirmed',]))
            ->get();

    }

    public static function getTasksForAllocation()
    {
        $isAdmin = UsersRepositories::isAdmin();

        return DB::table('task')
            ->select(
                'task.id_task',
                DB::raw('(
                    SELECT status.id_status
                    FROM status_history
                    LEFT JOIN status ON status_history.id_status = status.id_status
                    WHERE status_history.element_id = task.id_task
                    AND status_history.active = 1
                    AND status.element_type = "task"
                    AND status.status_type = "client"
                    ORDER BY status_history.created_at DESC
                    LIMIT 1
                ) as id_status'),
                'project.id_client',
                'task.id_product',
                'task.id_directory',
                'task.year',
                'task.id_guide',
                'task.id_location',
                'task.id_practice',
                'task.agreed_deadline',
                'task.deadline',
                'task.confirmed',
                DB::raw('CAST(COALESCE(project.owner, 0) AS UNSIGNED) as owner'),
                DB::raw('CAST(COALESCE(task.id_senior_consultant, 0) AS UNSIGNED) as id_senior_consultant'),
                DB::raw('CAST(COALESCE(task.id_consultant, 0) AS UNSIGNED) as id_consultant'),
                DB::raw('CAST(COALESCE(task.id_lds, 0) AS UNSIGNED) as id_lds'),
                DB::raw('CAST(COALESCE(task.id_coordinator, 0) AS UNSIGNED) as id_coordinator'),
                'task.deleted'
            )
            ->leftJoin('project', function($join){
                $join->on('task.id_project', '=', 'project.id_project');
            })
            ->leftJoin('directory', function($join){
                $join->on('task.id_directory', '=', 'directory.id_directory');
            })
            ->leftJoin('guide', function($join){
                $join->on('task.id_guide', '=', 'guide.id_guide');
            })
            ->leftJoin('location', function($join){
                $join->on('task.id_location', '=', 'location.id_location');
            })
            ->leftJoin('practice', function($join){
                $join->on('task.id_practice', '=', 'practice.id_practice');
            })
            ->where('task.deleted', 0)
            ->when(!$isAdmin, function ($query) {
                $id_role = Role::where(['code' => 'head_of_coordination', 'active' => 1])->first()->id_role;
                $user = Auth::user();
                if (!$user->userRole()->where('id_role', $id_role)->exists()) {
                    $idUser = $user->id_user;
                    return $query->where('project.owner', $idUser)->where('task.deleted', 0)
                        ->orwhere('task.id_senior_consultant', $idUser)->where('task.deleted', 0)
                        ->orwhere('task.id_consultant', $idUser)->where('task.deleted', 0)
                        ->orwhere('task.id_lds', $idUser)->where('task.deleted', 0);
                }
            })
            ->orderByRaw('LEFT(directory.name, 1) asc')
            ->orderByRaw('LEFT(guide.name, 1) asc')
            ->orderByRaw('LEFT(location.name, 1) asc')
            ->orderByRaw('LEFT(practice.name, 1) asc')
            ->get();
    }

    public static function getYearsTask()
    {
        $years = [];
        $yearsData = SubmissionsRepositories::getTasksForAllocation()->pluck('year');

        $yearsData[] = Carbon::now()->format('Y');

        foreach($yearsData->unique()->sort() as $item)
        {
            $year = new \stdClass();
            $year->year = (string) $item;
            $year->name = (string) $item;
            $years[] = $year;
        }
        //array_unshift($years, (object)['year' => '', 'name' => '']);
        return $years;
    }

    public static function getDeadlineYearsTask()
    {
        $years = [];
        $yearsData = SubmissionsRepositories::getTasksForAllocation()->pluck('deadline')->map(function($date){
            return Carbon::parse($date)->year;
        });

        $yearsData[] = Carbon::now()->format('Y');

        foreach($yearsData->unique() as $item)
        {
            $year = new \stdClass();
            $year->year = (string) $item;
            $year->name = (string) $item;
            $years[] = $year;
        }
        return $years;
    }
}
