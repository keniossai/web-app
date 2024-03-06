<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use App\Models\UserRole;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WlmRepositories
{
    /**This is an admin or not filter. If not admin, it will only show tasks you should be seeing */
    private static function applyFilter($query) {
        $isAdmin = UsersRepositories::isAdmin();
        $idUser = Auth::user()->id_user;

        if(!$isAdmin){
            return $query->where(function ($query) use ($idUser) {
                $query->orWhere('project.owner', $idUser)
                    ->orWhere('task.id_senior_consultant', $idUser)
                    ->orWhere('task.id_consultant', $idUser)
                    ->orWhere('task.id_lds', $idUser);
            })->where('task.deleted', 0);
        }
    }

    /**loads all wlm tasks */
    public static function getTasksWlm($filters)
    {
        $isAdmin = UsersRepositories::isAdmin();
        $subQuery = DB::table('task')
            ->select(
                'task.id_task',
                'project.name as project_name',
                'project.id_project',
                'client.name as client_name',
                'client.id_client',
                DB::raw('(
                    SELECT status.name
                    FROM status_history
                    LEFT JOIN status ON status_history.id_status = status.id_status
                    WHERE status_history.element_id = task.id_task
                    AND status_history.active = 1
                    AND status.element_type = "task"
                    AND status.status_type = "client"
                    ORDER BY status_history.created_at DESC
                    LIMIT 1
                ) as status_client'),
                DB::raw('(
                    SELECT status.name
                    FROM status_history
                    LEFT JOIN status ON status_history.id_status = status.id_status
                    WHERE status_history.element_id = task.id_task
                    AND status_history.active = 1
                    AND status.element_type = "task"
                    AND status.status_type = "consultant"
                    ORDER BY status_history.created_at DESC
                    LIMIT 1
                ) as status_consultant'),
                DB::raw('(
                    SELECT status.html_color
                    FROM status_history
                    LEFT JOIN status ON status_history.id_status = status.id_status
                    WHERE status_history.element_id = task.id_task
                    AND status_history.active = 1
                    AND status.element_type = "task"
                    AND status.status_type = "client"
                    ORDER BY status_history.created_at DESC
                    LIMIT 1
                ) as status_client_color'),
                'product.name as product_type',
                'practice.name as practice_name',
                'location.name as location_name',
                "location.id_location as location_id",
                'guide.name as guide_name',
                'task.id_guide',
                'directory.name as directory_name',
                'directory.id_directory',
                'task.agreed_deadline',
                'task.deadline',
                'task.confirmed',
                DB::raw("CONCAT(contact.name, ' ', contact.last_name) AS owner_name"),
                DB::raw("CONCAT(contact_sc.name, ' ', contact_sc.last_name) AS sc_name"),
                'task.id_senior_consultant',
                DB::raw("CONCAT(contact_c.name, ' ', contact_c.last_name) AS consultant_name"),
                'task.id_consultant',
                DB::raw("CONCAT(contact_lds.name, ' ', contact_lds.last_name) AS lds_name"),
                'task.id_lds',
                DB::raw("CONCAT(contact_coord.name, ' ', contact_coord.last_name) AS coord_name"),
                'task.id_coordinator',
                DB::raw('(
                    SELECT status.name
                    FROM status_history
                    LEFT JOIN status ON status_history.id_status = status.id_status
                    WHERE status_history.element_id = task.id_task
                    AND status_history.active = 1
                    AND status.element_type = "task"
                    AND status.status_type = "consultant"
                    ORDER BY status_history.created_at DESC
                    LIMIT 1
                ) as status_c'),
                DB::raw('(
                    SELECT status.html_color
                    FROM status_history
                    LEFT JOIN status ON status_history.id_status = status.id_status
                    WHERE status_history.element_id = task.id_task
                    AND status_history.active = 1
                    AND status.element_type = "task"
                    AND status.status_type = "consultant"
                    ORDER BY status_history.created_at DESC
                    LIMIT 1
                ) as html_color'),
                DB::raw('(
                    SELECT status_history.description
                    FROM status_history
                    LEFT JOIN status ON status_history.id_status = status.id_status
                    WHERE status_history.element_id = task.id_task
                    AND status_history.active = 1
                    AND status.element_type = "task"
                    AND status.status_type = "consultant"
                    ORDER BY status_history.created_at DESC
                    LIMIT 1
                ) as status_description'),
                DB::raw('(
                    SELECT status.order
                    FROM status_history
                    LEFT JOIN status ON status_history.id_status = status.id_status
                    WHERE status_history.element_id = task.id_task
                    AND status_history.active = 1
                    AND status.element_type = "task"
                    AND status.status_type = "consultant"
                    ORDER BY status_history.created_at DESC
                    LIMIT 1
                ) as order_status_c'),
                'client.picture',
                DB::raw('CAST(project.owner as UNSIGNED) as owner')

            )
            ->leftJoin('project', function($join){
                $join->on('task.id_project', '=', 'project.id_project');
            })
            ->leftJoin('client', function($join){
                $join->on('client.id_client', '=', 'project.id_client');
            })
            ->leftJoin('user', function($join){
                $join->on('user.id_user', '=', 'project.owner');
            })
            ->leftJoin('contact', function($join){
                $join->on('contact.id_user', '=', 'user.id_user');
            })
            ->leftJoin('user as user_sc', function($join){
                $join->on('user_sc.id_user', '=', 'task.id_senior_consultant');
            })
            ->leftJoin('contact as contact_sc', function($join){
                $join->on('contact_sc.id_user', '=', 'user_sc.id_user');
            })
            ->leftJoin('user as user_c', function($join){
                $join->on('user_c.id_user', '=', 'task.id_consultant');
            })
            ->leftJoin('contact as contact_c', function($join){
                $join->on('contact_c.id_user', '=', 'user_c.id_user');
            })
            ->leftJoin('user as user_lds', function($join){
                $join->on('user_lds.id_user', '=', 'task.id_lds');
            })
            ->leftJoin('contact as contact_lds', function($join){
                $join->on('contact_lds.id_user', '=', 'user_lds.id_user');
            })
            ->leftJoin('user as user_coord', function($join){
                $join->on('user_coord.id_user', '=', 'task.id_coordinator');
            })
            ->leftJoin('contact as contact_coord', function($join){
                $join->on('contact_coord.id_user', '=', 'user_coord.id_user');
            })
            ->leftJoin('product', function($join){
                $join->on('product.id_product', '=', 'task.id_product');
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
            //Filter INs
            ->when($filters->ids_client, function ($query, $ids_client) {
                $ids = is_array($ids_client) ? $ids_client : explode(",", $ids_client);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('project.id_client', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_directory, function ($query, $ids_directory) {
                $ids = is_array($ids_directory) ? $ids_directory : explode(",", $ids_directory);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('task.id_directory', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_guide, function ($query, $ids_guide){
                $ids = is_array($ids_guide) ? $ids_guide : explode(",", $ids_guide);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('task.id_guide', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_senior_consultant, function ($query, $ids_senior_consultant) {
                $ids = is_array($ids_senior_consultant) ? $ids_senior_consultant : explode(",", $ids_senior_consultant);

                if (in_array("-1", $ids)) {
                    $query->where(function ($query) use ($ids) {
                        $query->whereIn('task.id_senior_consultant', $ids)->orWhereNull('task.id_senior_consultant');
                    })->where('task.deleted', 0);
                } else {
                    $query->where(function ($query) use ($ids) {
                        $query->whereIn('task.id_senior_consultant', $ids);
                    })->where('task.deleted', 0);
                }

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_coordinator, function ($query, $ids_coordinator) {
                $ids = is_array($ids_coordinator) ? $ids_coordinator : explode(",", $ids_coordinator);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('task.id_coordinator', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_consultant, function ($query, $ids_consultant) {
                $ids = is_array($ids_consultant) ? $ids_consultant : explode(",", $ids_consultant);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('task.id_consultant', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_owner, function ($query, $ids_owner) {
                $ids = is_array($ids_owner) ? $ids_owner : explode(",", $ids_owner);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('project.owner', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_lds, function ($query, $ids_lds) {
                $ids = is_array($ids_lds) ? $ids_lds : explode(",", $ids_lds);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('task.id_lds', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_location, function ($query, $ids_location) {
                $ids = is_array($ids_location) ? $ids_location : explode(",", $ids_location);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('location.id_location', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->months, function ($query, $months) {
                $monthsNum = is_array($months) ? $months : explode(",", $months);
                $query->whereIn(DB::raw('MONTH(task.deadline)'), $monthsNum)->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            /**this filter is for directory year */
            ->when($filters->year, function ($query, $year) {
                $query->where('task.year', $year)->where('task.deleted', 0)->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            /**dealine year */
            ->when(true, function ($query) use ($filters) {
                $query->whereYear('task.deadline', $filters->deadline ?? 2023)->where('task.deleted', 0)->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_months_ad, function ($query, $ids_months_ad) {
                $monthsNumadd = is_array($ids_months_ad) ? $ids_months_ad : explode(",", $ids_months_ad);
                $query->whereIn(DB::raw('MONTH(task.agreed_deadline)'), $monthsNumadd)->where('task.deleted', 0);
                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when(!$isAdmin, function ($query) use ($filters){
                $idUser = Auth::user()->id_user;
                if($filters->ids_client == null && $filters->ids_senior_consultant == null && $filters->ids_directory == null && $filters->ids_coordinator == null
                    && $filters->ids_guide == null && $filters->ids_consultant == null && $filters->ids_owner == null && $filters->ids_lds == null && $filters->months == null && $filters->ids_months_ad == null){

                    $query->where('project.owner', $idUser)
                        ->orWhere('task.id_senior_consultant', $idUser)
                        ->orWhere('task.id_consultant', $idUser)
                        ->orWhere('task.id_lds', $idUser)
                        ->where('task.deleted', 0);
                    return $query;
                }
            })
            ->orderByRaw('LEFT(client_name, 1) asc');


        $objs = DB::table(DB::raw("({$subQuery->toSql()}) as sub"))
            ->mergeBindings($subQuery)
            ->when($filters->ids_status, function ($query, $ids_status) {
                $namesStatus = is_array($ids_status) ? $ids_status : explode(",", $ids_status);
                return $query->whereIn('status_client', $namesStatus);
            })
            ->when($filters->ids_consultant_status, function ($query, $ids_guide){
                $ids = is_array($ids_guide) ? $ids_guide : explode(",", $ids_guide);

                return $query->whereIn('status_consultant', $ids);            })
                /**FIXED: ORDER BY NEEDED TO BE APPLIED HERE AND NOT ON THE SUBQUERY. */
            ->when($filters->sortBy, function ($query, $sortBy) use ($filters){
                if($sortBy == 'consultantStatus'){
                    return $query->orderBy('order_status_c', $filters->order);
                }
                if($sortBy == 'deadline'){
                    return $query->orderBy('deadline', $filters->order);
                }
                if($sortBy == 'agreed_deadline'){
                    return $query->orderBy('agreed_deadline', $filters->order);
                }
            });

        if(!isset($filters->from)){
            $tasks['tasksGraph'] = $objs->get();
        }

        $tasks['tasks'] = $objs->paginate(10);

        return $tasks;
    }

    public static function getTasksWlmForTable($filters)
    {
        $isAdmin = UsersRepositories::isAdmin();
        $subQuery = DB::table('task')
            ->select(
                'task.id_task',
                'project.name as project_name',
                'task.id_project',
                'client.name as client_name',
                'client.id_client',
                DB::raw('(
                    SELECT status.name
                    FROM status_history
                    LEFT JOIN status ON status_history.id_status = status.id_status
                    WHERE status_history.element_id = task.id_task
                    AND status_history.active = 1
                    AND status.element_type = "task"
                    AND status.status_type = "client"
                    ORDER BY status_history.created_at DESC
                    LIMIT 1
                ) as status_client'),
                DB::raw('(
                    SELECT status.html_color
                    FROM status_history
                    LEFT JOIN status ON status_history.id_status = status.id_status
                    WHERE status_history.element_id = task.id_task
                    AND status_history.active = 1
                    AND status.element_type = "task"
                    AND status.status_type = "client"
                    ORDER BY status_history.created_at DESC
                    LIMIT 1
                ) as status_client_color'),
                'product.name as product_type',
                'practice.name as practice_name',
                'location.name as location_name',
                "location.id_location as location_id",
                'guide.name as guide_name',
                'directory.name as directory_name',
                'task.agreed_deadline',
                'task.deadline',
                'task.confirmed',
                'contact.name as owner_name',
                DB::raw("CONCAT(contact_sc.name, ' ', contact_sc.last_name) AS sc_name"),
                'contact_c.name as consultant_name',
                'contact_lds.name as lds_name',
                'contact_coord.name as coord_name',
                DB::raw('(
                    SELECT status.name
                    FROM status_history
                    LEFT JOIN status ON status_history.id_status = status.id_status
                    WHERE status_history.element_id = task.id_task
                    AND status_history.active = 1
                    AND status.element_type = "task"
                    AND status.status_type = "consultant"
                    ORDER BY status_history.created_at DESC
                    LIMIT 1
                ) as status_c'),
                DB::raw('(
                    SELECT status.html_color
                    FROM status_history
                    LEFT JOIN status ON status_history.id_status = status.id_status
                    WHERE status_history.element_id = task.id_task
                    AND status_history.active = 1
                    AND status.element_type = "task"
                    AND status.status_type = "consultant"
                    ORDER BY status_history.created_at DESC
                    LIMIT 1
                ) as html_color'),
                DB::raw('(
                    SELECT status_history.description
                    FROM status_history
                    LEFT JOIN status ON status_history.id_status = status.id_status
                    WHERE status_history.element_id = task.id_task
                    AND status_history.active = 1
                    AND status.element_type = "task"
                    AND status.status_type = "consultant"
                    ORDER BY status_history.created_at DESC
                    LIMIT 1
                ) as status_description'),
                DB::raw('(
                    SELECT status.order
                    FROM status_history
                    LEFT JOIN status ON status_history.id_status = status.id_status
                    WHERE status_history.element_id = task.id_task
                    AND status_history.active = 1
                    AND status.element_type = "task"
                    AND status.status_type = "consultant"
                    ORDER BY status_history.created_at DESC
                    LIMIT 1
                ) as order_status_c'),
                'client.picture',
                'project.owner'
            )
            ->leftJoin('project', function($join){
                $join->on('task.id_project', '=', 'project.id_project');
            })

            ->leftJoin('client', function($join){
                $join->on('client.id_client', '=', 'project.id_client');
            })
            ->leftJoin('user', function($join){
                $join->on('user.id_user', '=', 'project.owner');
            })
            ->leftJoin('contact', function($join){
                $join->on('contact.id_user', '=', 'user.id_user');
            })
            ->leftJoin('user as user_sc', function($join){
                $join->on('user_sc.id_user', '=', 'task.id_senior_consultant');
            })
            ->leftJoin('contact as contact_sc', function($join){
                $join->on('contact_sc.id_user', '=', 'user_sc.id_user');
            })
            ->leftJoin('user as user_c', function($join){
                $join->on('user_c.id_user', '=', 'task.id_consultant');
            })
            ->leftJoin('contact as contact_c', function($join){
                $join->on('contact_c.id_user', '=', 'user_c.id_user');
            })
            ->leftJoin('user as user_lds', function($join){
                $join->on('user_lds.id_user', '=', 'task.id_lds');
            })
            ->leftJoin('contact as contact_lds', function($join){
                $join->on('contact_lds.id_user', '=', 'user_lds.id_user');
            })
            ->leftJoin('user as user_coord', function($join){
                $join->on('user_coord.id_user', '=', 'task.id_coordinator');
            })
            ->leftJoin('contact as contact_coord', function($join){
                $join->on('contact_coord.id_user', '=', 'user_coord.id_user');
            })
            ->leftJoin('product', function($join){
                $join->on('product.id_product', '=', 'task.id_product');
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
            ->when($filters->ids_client, function ($query, $ids_client) {
                $ids = is_array($ids_client) ? $ids_client : explode(",", $ids_client);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('project.id_client', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_directory, function ($query, $ids_directory) {
                $ids = is_array($ids_directory) ? $ids_directory : explode(",", $ids_directory);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('task.id_directory', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_guide, function ($query, $ids_guide){
                $ids = is_array($ids_guide) ? $ids_guide : explode(",", $ids_guide);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('task.id_guide', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_senior_consultant, function ($query, $ids_senior_consultant) {
                $ids = is_array($ids_senior_consultant) ? $ids_senior_consultant : explode(",", $ids_senior_consultant);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('task.id_senior_consultant', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_coordinator, function ($query, $ids_coordinator) {
                $ids = is_array($ids_coordinator) ? $ids_coordinator : explode(",", $ids_coordinator);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('task.id_coordinator', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_consultant, function ($query, $ids_consultant) {
                $ids = is_array($ids_consultant) ? $ids_consultant : explode(",", $ids_consultant);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('task.id_consultant', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_owner, function ($query, $ids_owner) {
                $ids = is_array($ids_owner) ? $ids_owner : explode(",", $ids_owner);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('project.owner', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_lds, function ($query, $ids_lds) {
                $ids = is_array($ids_lds) ? $ids_lds : explode(",", $ids_lds);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('task.id_lds', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_location, function ($query, $ids_location) {
                $ids = is_array($ids_location) ? $ids_location : explode(",", $ids_location);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('location.id_location', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->months, function ($query, $months) {
                $monthsNum = is_array($months) ? $months : explode(",", $months);
                $query->whereIn(DB::raw('MONTH(task.deadline)'), $monthsNum)->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->year, function ($query, $year) {
                $query->where('task.year', $year)->where('task.deleted', 0)->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when(true, function ($query) use ($filters) {
                $query->whereYear('task.deadline', $filters->deadline ?? 2023)->where('task.deleted', 0)->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->wh
            ->when($filters->ids_months_ad, function ($query, $ids_months_ad) {
                $monthsNum = is_array($ids_months_ad) ? $ids_months_ad : explode(",", $ids_months_ad);
                $query->whereIn(DB::raw('MONTH(task.agreed_deadline)'), $monthsNum)->where('task.deleted', 0);
                WlmRepositories::applyFilter($query);
                return $query;
            })
            ->when($filters->sortBy, function ($query, $sortBy) use ($filters){
                if($sortBy == 'owner'){
                    return $query->orderBy('owner_name', $filters->order);
                }
                if($sortBy == 'deadline'){
                    return $query->orderBy('task.deadline', $filters->order);
                }
                if($sortBy == 'sc'){
                    return $query->orderBy('sc_name', $filters->order);
                }
                if($sortBy == 'consultant'){
                    return $query->orderBy('consultant_name', $filters->order);
                }
                if($sortBy == 'lds'){
                    return $query->orderBy('lds_name', $filters->order);
                }
                if($sortBy == 'coord'){
                    return $query->orderBy('coord_name', $filters->order);
                }
                if($sortBy == 'agreed_deadline'){
                    return $query->orderBy('task.agreed_deadline', $filters->order);
                }

            })
            ->when(!$isAdmin, function ($query) use ($filters){
                $idUser = Auth::user()->id_user;
                if($filters->ids_client == null && $filters->ids_senior_consultant == null && $filters->ids_directory == null && $filters->ids_coordinator == null
                    && $filters->ids_guide == null && $filters->ids_consultant == null && $filters->ids_owner == null && $filters->ids_lds == null && $filters->months == null){

                    $query->where('project.owner', $idUser)
                        ->orWhere('task.id_senior_consultant', $idUser)
                        ->orWhere('task.id_consultant', $idUser)
                        ->orWhere('task.id_lds', $idUser)
                        ->where('task.deleted', 0);
                    return $query;
                }
            })
            ->orderByRaw('LEFT(client_name, 1) asc');

        $tasks = DB::table(DB::raw("({$subQuery->toSql()}) as sub"))
            ->mergeBindings($subQuery)
            ->when($filters->ids_status, function ($query, $ids_status) {
                $namesStatus = is_array($ids_status) ? $ids_status : explode(",", $ids_status);
                return $query->whereIn('status_client', $namesStatus);
            })
            ->when($filters->sortBy, function ($query, $sortBy) use ($filters){
                if($sortBy == 'consultantStatus'){
                    return $query->orderBy('order_status_c', $filters->order);
                }
            })
            ->paginate(10);

        return $tasks;
    }

    public static function getSCofProjects()
    {
        $ids_project = Project::where('deleted', 0)->pluck('id_project')->unique();
        $ids_sc = Task::whereIn('id_project', $ids_project)->where('deleted', 0)->pluck('id_senior_consultant')->unique();
        $users = DB::table('user')
            ->select('user.id_user as id_senior_consultant', DB::raw("CONCAT(contact.name, ' ', contact.last_name) AS name"))
            ->leftJoin('contact', function($join){
                $join->on('user.id_user', '=', 'contact.id_user');
            })
            ->whereIn('user.id_user', $ids_sc)
            ->get();

        return $users;
    }

    public static function getCoordOfProjects()
    {
        $ids_project = Project::where('deleted', 0)->pluck('id_project')->unique();
        $ids_coordinator = Task::whereIn('id_project', $ids_project)->where('deleted', 0)->pluck('id_coordinator')->unique();
        $users = DB::table('user')
            ->select('user.id_user as id_coordinator', DB::raw("CONCAT(contact.name, ' ', contact.last_name) AS name"))
            ->leftJoin('contact', function($join){
                $join->on('user.id_user', '=', 'contact.id_user');
            })
            ->whereIn('user.id_user', $ids_coordinator)
            ->get();

        return $users;
    }

    public static function getYearsOfProjects()
    {
        $years = Project::where('deleted', 0)->pluck('year')->unique()->sort();

        return $years;
    }

    public static function getDeadlineYearsOfProjects()
    {
        $years = SubmissionsRepositories::getTasksForAllocation()->pluck('deadline')->map(function($date){
            return Carbon::parse($date)->year;
        })->unique()
        ->sort();
        return $years;
    }

    public static function getGuidesOfProjects()
    {
        $ids_project = Project::where('deleted', 0)->pluck('id_project')->unique();
        $ids_guide = Task::whereIn('id_project', $ids_project)->where('deleted', 0)->pluck('id_guide')->unique();
        $guides = DB::table('guide')
            ->select('id_guide', 'name')
            ->whereIn('id_guide', $ids_guide)
            ->get();

        return $guides;
    }
    // comment - gets data for filters

    public static function getConsultantsOfProjects()
    {
        $ids_project = Project::where('deleted', 0)->pluck('id_project')->unique();
        $ids_consultant = Task::whereIn('id_project', $ids_project)->where('deleted', 0)->pluck('id_consultant')->unique();
        $users = DB::table('user')
            ->select('user.id_user as id_consultant', DB::raw("CONCAT(contact.name, ' ', contact.last_name) AS name"))
            ->leftJoin('contact', function($join){
                $join->on('user.id_user', '=', 'contact.id_user');
            })
            ->whereIn('user.id_user', $ids_consultant)
            ->get();

        return $users;
    }

    public static function getOwnersOfProjects()
    {
        $owners = Project::where('deleted', 0)->pluck('owner')->unique();
        $users = DB::table('user')
            ->select('user.id_user as owner', DB::raw("CONCAT(contact.name, ' ', contact.last_name) AS name"))
            ->leftJoin('contact', function($join){
                $join->on('user.id_user', '=', 'contact.id_user');
            })
            ->whereIn('user.id_user', $owners)
            ->get();

        return $users;
    }

    public static function getLdsOfProjects()
    {
        $ids_project = Project::where('deleted', 0)->pluck('id_project')->unique();
        $ids_lds = Task::whereIn('id_project', $ids_project)->where('deleted', 0)->pluck('id_lds')->unique();
        $users = DB::table('user')
            ->select('user.id_user as id_lds', DB::raw("CONCAT(contact.name, ' ', contact.last_name) AS name"))
            ->leftJoin('contact', function($join){
                $join->on('user.id_user', '=', 'contact.id_user');
            })
            ->whereIn('user.id_user', $ids_lds)
            ->get();

        return $users;
    }

    public static function getClientStatus()
    {
        $result = DB::table('status')
            ->select(
                'id_status',
                'name'
            )
            ->where(['element_type' => 'task', 'status_type' => 'client', 'deleted' => 0])
            ->orderByRaw('LEFT(name, 2) asc')
            ->get();

        return $result;
    }

    public static function getConsultantStatus()
    {

        $ids_project = Project::where('deleted', 0)->pluck('id_project')->unique();
        $ids_consultant_status = Task::whereIn('id_project', $ids_project)->where('deleted', 0)->pluck('id_coordinator')->unique();


        $result = DB::table('status')
            ->select(
                'id_status',
                'name'
            )
            ->where(['element_type' => 'task', 'status_type' => 'consultant', 'deleted' => 0])
            ->orderByRaw('LEFT(name, 2) asc')
            ->get();

        return $result;

    }

    public static function setDeadlineStatus($task)
    {
        $current_date = new DateTime();
        $deadline = new DateTime($task->deadline);
        $textColor = '';
        $remaining_three_weeks = $current_date->diff($deadline)->format('%r%a') >= 21;
        $remaining_two_weeks = $current_date->diff($deadline)->format('%r%a') >= 14;
        $remaining_one_week = $current_date->diff($deadline)->format('%r%a') >= 7;
        $less_than_a_week = $current_date->diff($deadline)->format('%r%a') < 7;

        if($task->status_c == 'done'){
            return $textColor = 'success';
        }
        if ($remaining_three_weeks) { //faltando 3 semanas
            $textColor = 'dark';
        } elseif ($remaining_two_weeks) { //faltando 2 semanas
            $textColor = 'warning';
        } elseif ($remaining_one_week) { //faltando 1 semana
            $textColor = 'danger';
        } elseif($less_than_a_week) { //faltando menos de 1 semana
            if($current_date->diff($deadline)->format('%r%a') < 0){
                if($task->status_c != 'done'){
                    $textColor = 'danger';
                }
            } else {
                $textColor = 'danger';
            }
        }

        return $textColor;
    }

    //Kanban functions
    public static function getTasksWlmKanban($filters)
    {
        $isAdmin = UsersRepositories::isAdmin();
        $subQuery = DB::table('task')
            ->select(
                'task.id_task',
                'project.name as project_name',
                'project.year',
                'project.id_project',
                'client.name as client_name',
                'client.id_client',
                DB::raw('(
                    SELECT status.name
                    FROM status_history
                    LEFT JOIN status ON status_history.id_status = status.id_status
                    WHERE status_history.element_id = task.id_task
                    AND status_history.active = 1
                    AND status.element_type = "task"
                    AND status.status_type = "client"
                    ORDER BY status_history.created_at DESC
                    LIMIT 1
                ) as status_client'),
                DB::raw('(
                    SELECT status.name
                    FROM status_history
                    LEFT JOIN status ON status_history.id_status = status.id_status
                    WHERE status_history.element_id = task.id_task
                    AND status_history.active = 1
                    AND status.element_type = "task"
                    AND status.status_type = "consultant"
                    ORDER BY status_history.created_at DESC
                    LIMIT 1
                ) as status_consultant'),
                DB::raw('(
                    SELECT status.html_color
                    FROM status_history
                    LEFT JOIN status ON status_history.id_status = status.id_status
                    WHERE status_history.element_id = task.id_task
                    AND status_history.active = 1
                    AND status.element_type = "task"
                    AND status.status_type = "client"
                    ORDER BY status_history.created_at DESC
                    LIMIT 1
                ) as status_client_color'),
                'product.name as product_type',
                'practice.name as practice_name',
                'location.name as location_name',
                "location.id_location as location_id",
                'guide.name as guide_name',
                'task.id_guide',
                'directory.name as directory_name',
                'directory.id_directory',
                'task.agreed_deadline',
                'task.deadline',
                'task.confirmed',
                DB::raw("CONCAT(contact.name, ' ', contact.last_name) AS owner_name"),
                DB::raw("CONCAT(contact_sc.name, ' ', contact_sc.last_name) AS sc_name"),
                'task.id_senior_consultant',
                DB::raw("CONCAT(contact_c.name, ' ', contact_c.last_name) AS consultant_name"),
                'task.id_consultant',
                DB::raw("CONCAT(contact_lds.name, ' ', contact_lds.last_name) AS lds_name"),
                'task.id_lds',
                DB::raw("CONCAT(contact_coord.name, ' ', contact_coord.last_name) AS coord_name"),
                'task.id_coordinator',
                DB::raw('(
                    SELECT status.name
                    FROM status_history
                    LEFT JOIN status ON status_history.id_status = status.id_status
                    WHERE status_history.element_id = task.id_task
                    AND status_history.active = 1
                    AND status.element_type = "task"
                    AND status.status_type = "consultant"
                    ORDER BY status_history.created_at DESC
                    LIMIT 1
                ) as status_c'),
                DB::raw('(
                    SELECT status.html_color
                    FROM status_history
                    LEFT JOIN status ON status_history.id_status = status.id_status
                    WHERE status_history.element_id = task.id_task
                    AND status_history.active = 1
                    AND status.element_type = "task"
                    AND status.status_type = "consultant"
                    ORDER BY status_history.created_at DESC
                    LIMIT 1
                ) as html_color'),
                DB::raw('(
                    SELECT status_history.description
                    FROM status_history
                    LEFT JOIN status ON status_history.id_status = status.id_status
                    WHERE status_history.element_id = task.id_task
                    AND status_history.active = 1
                    AND status.element_type = "task"
                    AND status.status_type = "consultant"
                    ORDER BY status_history.created_at DESC
                    LIMIT 1
                ) as status_description'),
                DB::raw('(
                    SELECT status.order
                    FROM status_history
                    LEFT JOIN status ON status_history.id_status = status.id_status
                    WHERE status_history.element_id = task.id_task
                    AND status_history.active = 1
                    AND status.element_type = "task"
                    AND status.status_type = "consultant"
                    ORDER BY status_history.created_at DESC
                    LIMIT 1
                ) as order_status_c'),
                'client.picture',
                DB::raw('CAST(project.owner as UNSIGNED) as owner')
            )
            ->leftJoin('project', function($join){
                $join->on('task.id_project', '=', 'project.id_project');
            })
            ->leftJoin('client', function($join){
                $join->on('client.id_client', '=', 'project.id_client');
            })
            ->leftJoin('user', function($join){
                $join->on('user.id_user', '=', 'project.owner');
            })
            ->leftJoin('contact', function($join){
                $join->on('contact.id_user', '=', 'user.id_user');
            })
            ->leftJoin('user as user_sc', function($join){
                $join->on('user_sc.id_user', '=', 'task.id_senior_consultant');
            })
            ->leftJoin('contact as contact_sc', function($join){
                $join->on('contact_sc.id_user', '=', 'user_sc.id_user');
            })
            ->leftJoin('user as user_c', function($join){
                $join->on('user_c.id_user', '=', 'task.id_consultant');
            })
            ->leftJoin('contact as contact_c', function($join){
                $join->on('contact_c.id_user', '=', 'user_c.id_user');
            })
            ->leftJoin('user as user_lds', function($join){
                $join->on('user_lds.id_user', '=', 'task.id_lds');
            })
            ->leftJoin('contact as contact_lds', function($join){
                $join->on('contact_lds.id_user', '=', 'user_lds.id_user');
            })
            ->leftJoin('user as user_coord', function($join){
                $join->on('user_coord.id_user', '=', 'task.id_coordinator');
            })
            ->leftJoin('contact as contact_coord', function($join){
                $join->on('contact_coord.id_user', '=', 'user_coord.id_user');
            })
            ->leftJoin('product', function($join){
                $join->on('product.id_product', '=', 'task.id_product');
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
            ->when($filters->ids_client, function ($query, $ids_client) {
                $ids = is_array($ids_client) ? $ids_client : explode(",", $ids_client);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('project.id_client', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_directory, function ($query, $ids_directory) {
                $ids = is_array($ids_directory) ? $ids_directory : explode(",", $ids_directory);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('task.id_directory', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_location, function ($query, $ids_location) {
                $ids = is_array($ids_location) ? $ids_location : explode(",", $ids_location);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('location.id_location', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_guide, function ($query, $ids_guide){
                $ids = is_array($ids_guide) ? $ids_guide : explode(",", $ids_guide);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('task.id_guide', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_senior_consultant, function ($query, $ids_senior_consultant) {
                $ids = is_array($ids_senior_consultant) ? $ids_senior_consultant : explode(",", $ids_senior_consultant);

                if (in_array("-1", $ids)) {
                    $query->where(function ($query) use ($ids) {
                        $query->whereIn('task.id_senior_consultant', $ids)->orWhereNull('task.id_senior_consultant');
                    })->where('task.deleted', 0);
                } else {
                    $query->where(function ($query) use ($ids) {
                        $query->whereIn('task.id_senior_consultant', $ids);
                    })->where('task.deleted', 0);
                }

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_coordinator, function ($query, $ids_coordinator) {
                $ids = is_array($ids_coordinator) ? $ids_coordinator : explode(",", $ids_coordinator);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('task.id_coordinator', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_consultant, function ($query, $ids_consultant) {
                $ids = is_array($ids_consultant) ? $ids_consultant : explode(",", $ids_consultant);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('task.id_consultant', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_owner, function ($query, $ids_owner) {
                $ids = is_array($ids_owner) ? $ids_owner : explode(",", $ids_owner);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('project.owner', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->ids_lds, function ($query, $ids_lds) {
                $ids = is_array($ids_lds) ? $ids_lds : explode(",", $ids_lds);

                $query->where(function ($query) use ($ids) {
                    $query->whereIn('task.id_lds', $ids);
                })->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->months, function ($query, $months) {
                $monthsNum = is_array($months) ? $months : explode(",", $months);
                $query->whereIn(DB::raw('MONTH(task.deadline)'), $monthsNum)->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->year, function ($query, $year) {
                $query->where('task.year', $year)->where('task.deleted', 0)->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when(true, function ($query) use ($filters) {
                $query->whereYear('task.deadline', $filters->deadline ?? 2023)->where('task.deleted', 0)->where('task.deleted', 0);

                WlmRepositories::applyFilter($query);

                return $query;
            })
            ->when($filters->sortBy, function ($query, $sortBy) use ($filters){
                if($sortBy == 'owner'){
                    return $query->orderBy('owner_name', $filters->order);
                }
                if($sortBy == 'deadline'){
                    return $query->orderBy('task.deadline', $filters->order);
                }
                if($sortBy == 'sc'){
                    return $query->orderBy('sc_name', $filters->order);
                }
                if($sortBy == 'consultant'){
                    return $query->orderBy('consultant_name', $filters->order);
                }
                if($sortBy == 'lds'){
                    return $query->orderBy('lds_name', $filters->order);
                }
                if($sortBy == 'coord'){
                    return $query->orderBy('coord_name', $filters->order);
                }
            })
            ->when($filters->ids_months_ad, function ($query, $ids_months_ad) {
                $monthsNumad = is_array($ids_months_ad) ? $ids_months_ad : explode(",", $ids_months_ad);
                $query->whereIn(DB::raw('MONTH(task.agreed_deadline)'), $monthsNumad)->where('task.deleted', 0);
                WlmRepositories::applyFilter($query);
                return $query;
            })
            ->when(!$isAdmin, function ($query) use ($filters){
                $idUser = Auth::user()->id_user;
                if($filters->ids_client == null && $filters->ids_senior_consultant == null && $filters->ids_directory == null && $filters->ids_coordinator == null
                    && $filters->ids_guide == null && $filters->ids_consultant == null && $filters->ids_owner == null && $filters->ids_lds == null && $filters->months == null && $filters->ids_months_ad == null){

                    $query->where('project.owner', $idUser)
                        ->orWhere('task.id_senior_consultant', $idUser)
                        ->orWhere('task.id_consultant', $idUser)
                        ->orWhere('task.id_lds', $idUser)
                        ->where('task.deleted', 0);
                    return $query;
                }
            })
            ->orderByRaw('LEFT(client_name, 1) asc');

        $objs = DB::table(DB::raw("({$subQuery->toSql()}) as sub"))
            ->mergeBindings($subQuery)
            ->when($filters->ids_status, function ($query, $ids_status) {
                $namesStatus = is_array($ids_status) ? $ids_status : explode(",", $ids_status);
                return $query->whereIn('status_client', $namesStatus);
            });

        $tasks['tasksFilter'] = $objs->get();
        $grouped = $tasks['tasksFilter']->groupBy('status_c')->mapWithKeys(function ($items, $key) {
            if ($key == '') {
                $key = 'null';
            }
            return [$key => $items];
        });
        $counts = [];
        foreach ($grouped as $status => $group) {
            $counts[$status] = $group->count();
        }

        $tasks['countByStatus'] = $counts;
        $tasks['tasks'] = $objs->paginate(10);

        return $tasks;
    }
}
