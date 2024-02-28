<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('system-catalogs.roles')->with(['roles' => Role::where('active', 1)->get()]);
    }

    public function read(Request $request)
    {
        $role = Role::find($request->id);
        return view('system-catalogs.role')->with(['role' => $role]);
    }

    public function edit(Request $request)
    {
        $role = Role::find($request->id);

        return view('system-catalogs.role')->with(['role' => $role, 'section' => 'edit']);
    }

    public function save(Request $request)
    {
        $role = Role::findOrNew($request->id_role);
        $role->name = $request->name;
        $role->description = $request->description;

        $role->exists ? $role->update() : $role->save();

        return redirect()->route('read-role', ['id' => $role->id_role]);
    }

    public function deactivate(Request $request)
    {
        $role = Role::find($request->id_role);
        $role->update([
            'active' => 0
        ]);

        return response('delete success', 200);
    }

    public function deleteUserRole(Request $request)
    {
        $userRole = UserRole::find($request->id_userrole);
        $userRole->delete();

        return response('delete success', 200);
    }

    public function saveUserRole(Request $request)
    {
        $userRole = UserRole::firstOrNew(['id_user' => $request->id_user, 'id_role' => $request->id_role]);

        if($userRole->exists){
            Session::flash('message', 'The user is already exists');
            Session::flash('type', 'error');
            Session::flash('title', 'Error');

            return back();
        } else {
            $userRole->save();

            Session::flash('message', 'The user is added successfully');
            Session::flash('type', 'success');
            Session::flash('title', 'Success');

            return redirect()->route('read-role', ['id' => $userRole->id_role]);
        }
    }
}
