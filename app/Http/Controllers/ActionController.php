<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Permission;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('system-catalogs.actions')->with(['actions' => Action::where('active', 1)->get()]);
    }

    public function save(Request $request)
    {
        $action = Action::findOrNew($request->id_action);
        $action->module = $request->module;
        $action->name = $request->name;
        $action->description = $request->description;

        $action->exists ? $action->update() : $action->save();

        return response('update success', 200);
    }

    public function read(Request $request)
    {
        $action = Action::find($request->id_action);
        return response($action);
    }

    public function deactivate(Request $request)
    {
        $action = Action::find($request->id_action);
        $action->update([
            'active' => 0
        ]);

        $permissions = Permission::where([
            'id_action' => $action->id_action,
            'active' => 1
        ])->get();

        foreach($permissions as $permission)
        {
            $permission->update([
                'active' => 0
            ]);
        }

        return response('delete success', 200);
    }
}
