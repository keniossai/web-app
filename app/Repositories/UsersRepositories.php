<?php

namespace App\Repositories;

use App\Models\Group;
use App\Models\GroupDetail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersRepositories
{
    public static function usersGroup()
    {

        $roles = Role::whereIn('id_role', function($query) {
            $query->select('id_role')
                ->from('user_role')
                ->where('id_user', Auth::user()->id_user);
       })->pluck('code');

        $group = Group:: //whereIn('role', $roles)
            join('group_detail', 'group.id_group', '=', 'group_detail.id_group')
            ->where('group_detail.id_user', '=', Auth::user()->id_user)
            ->where('group_detail.is_admin', '=', 1)
            ->get();

        $ids_user = GroupDetail::whereIn('id_group', $group->pluck('id_group'))->where('group_detail.deleted', '=', 0)->pluck('id_user');

        return $ids_user;
    }
    public static function users($name)
    {
        return User::where('active', 1)->whereHas('role', function ($query) use ($name){
            $query->where('name', '=', $name);
            $query->where('active', '=', 1);
        })->get();
    }

    public static function getUsersSC()
    {
        $result = DB::table('user')
            ->select(
                'user.id_user as id_senior_consultant',
                DB::raw("CONCAT(contact.name, ' ', contact.last_name) AS name")
            )
            ->Join('user_role', function($join){
                $join->on('user_role.id_user', '=', 'user.id_user');
            })
            ->Join('role', function($join){
                $join->on('user_role.id_role', '=', 'role.id_role')->where([
                    'role.name' => 'Senior Consultant',
                ]);
            })
            ->Join('contact', function($join){
                $join->on('user.id_user', '=', 'contact.id_user');
            })
            ->orderByRaw('LEFT(contact.name, 2) asc')
            ->get();

            $result = $result->toArray();
            array_unshift($result, (object)['id_senior_consultant' => '', 'name' => '']);

        return $result;
    }

    public static function getUsersC()
    {
        $result = DB::table('user')
            ->select(
                'user.id_user as id_consultant',
                DB::raw("CONCAT(contact.name, ' ', contact.last_name) AS name")
            )
            ->Join('user_role', function($join){
                $join->on('user_role.id_user', '=', 'user.id_user');
            })
            ->Join('role', function($join){
                $join->on('user_role.id_role', '=', 'role.id_role')->where([
                    'role.name' => 'Consultant',
                ]);
            })
            ->Join('contact', function($join){
                $join->on('user.id_user', '=', 'contact.id_user');
            })
            ->orderByRaw('LEFT(contact.name, 2) asc')
            ->get();

            $result = $result->toArray();
            array_unshift($result, (object)['id_consultant' => '', 'name' => '']);

        return $result;
    }

    public static function getUsersLDS()
    {
        $result = DB::table('user')
            ->select(
                'user.id_user as id_lds',
                DB::raw("CONCAT(contact.name, ' ', contact.last_name) AS name")
            )
            ->Join('user_role', function($join){
                $join->on('user_role.id_user', '=', 'user.id_user');
            })
            ->Join('role', function($join){
                $join->on('user_role.id_role', '=', 'role.id_role')->where([
                    'role.name' => 'LDS',
                ]);
            })
            ->Join('contact', function($join){
                $join->on('user.id_user', '=', 'contact.id_user');
            })
            ->orderByRaw('LEFT(contact.name, 2) asc')
            ->get();

            $result = $result->toArray();
            array_unshift($result, (object)['id_lds' => '', 'name' => '']);

        return $result;
    }

    public static function getUsersCoord()
    {
        $result = DB::table('user')
            ->select(
                'user.id_user as id_coordinator',
                DB::raw("CONCAT(contact.name, ' ', contact.last_name) AS name")
            )
            ->Join('user_role', function($join){
                $join->on('user_role.id_user', '=', 'user.id_user');
            })
            ->Join('role', function($join){
                $join->on('user_role.id_role', '=', 'role.id_role')->where([
                    'role.name' => 'Coordinator',
                ]);
            })
            ->Join('contact', function($join){
                $join->on('user.id_user', '=', 'contact.id_user');
            })
            ->orderByRaw('LEFT(contact.name, 2) asc')
            ->get();

            $result = $result->toArray();
            array_unshift($result, (object)['id_coordinator' => '', 'name' => '']);

        return $result;
    }

    public static function getUsersForOwners()
    {
        $result = DB::table('user')
            ->select(
                'user.id_user as owner',
                DB::raw("CONCAT(contact.name, ' ', contact.last_name) AS name")
            )
            ->Join('contact', function($join){
                $join->on('user.id_user', '=', 'contact.id_user');
            })
            ->orderByRaw('LEFT(contact.name, 2) asc')
            ->get();

            $result = $result->toArray();
            array_unshift($result, (object)['owner' => '', 'name' => '']);

        return $result;
    }

    public static function isAllowed($action)
    {
        $isAllowed = false;
        foreach(Auth::user()->userRole as $item)
        {

            if($item->role->is_allowed($action))
            {
                 $isAllowed = true;
            }
        }

        if($isAllowed)
        {
            return $isAllowed;
        }
    }

    public static function isAdmin()
    {
        $id_role = Role::where(['code' => 'admin', 'active' => 1])->first()->id_role;
        $user = Auth::user();
        if ($user->userRole()->where('id_role', $id_role)->exists()) {
            return true;
        } else {
            return false;
        }
    }
}
