<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('system-catalogs.permissions')->with(['permissions' => Permission::where('active', 1)->get()]);
    }

    public function save(Request $request)
    {
        $permission = Permission::findOrNew($request->id_permission);
        $permission->id_action = $request->id_action;
        $permission->id_role = $request->id_role;

        $permission->exists ? $permission->update() : $permission->save();

        return response('update success', 200);
    }

    public function read(Request $request)
    {
        $permission = Permission::find($request->id_permission);
        return response($permission);
    }

    public function delete(Request $request)
    {
        $permission = Permission::find($request->id_permission);
        $permission->delete();

        return response('delete success', 200);
    }
}
