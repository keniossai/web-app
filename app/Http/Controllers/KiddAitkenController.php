<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KiddAitkenController extends Controller
{

    /**
     * @REMOVE - This function is useless. This functionality is to search for menu items
     * This functionality has been removed and for some reason is causing troubles now. 
     * disabling it for the moment
     
    public function search(Request $request){
        $user = Auth::user();
        $ids_action = Permission::whereIn('id_role', $user->userRole->pluck('id_role'))->where('active', 1)->pluck('id_action');

        $menus = DB::table('menu_item')->whereIn('menu_item.id_action', $ids_action)
            ->join('action', 'action.id_action', '=', 'menu_item.id_action')
            ->where('menu_item.name', 'like', '%'.$request->search.'%')
            ->select('menu_item.id_menuitem', 'menu_item.name as name_menu', 'action.id_action', 'action.name as action')
            ->get();

        return view('partials.search-result')->with(['menus' => $menus]);
    }
    */

    public function searchUsers(Request $request)
    {
        $users = DB::table('user')
            ->join('contact', 'contact.id_user', '=', 'user.id_user')
            ->where('user.id_user', '!=', Auth::user()->id_user)
            ->when($request->search, function ($query, $search) {
                if($search != 'all'){
                    $query->where('contact.name', 'like', '%'.$search.'%')
                        ->orWhere('contact.last_name', 'like', '%'.$search.'%');
                }
            })
            ->select('user.id_user',  DB::raw("CONCAT(contact.name, ' ', contact.last_name) AS fullName"),)
            ->get();

        return view('partials.search-users')->with(['users' => $users]);
    }
}
