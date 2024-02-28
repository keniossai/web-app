<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('system-catalogs.menuitems')->with(['menuitems' => MenuItem::where('active', 1)->get()]);
    }

    public function save(Request $request)
    {
        $menuitem = MenuItem::findOrNew($request->id_menuitem);
        $menuitem->name = $request->name;
        $menuitem->father_id_menuitem = $request->father_id_menuitem;
        $menuitem->id_action = $request->id_action;
        $menuitem->order = $request->order;

        $menuitem->exists ? $menuitem->update() : $menuitem->save();

        return response('update success', 200);
    }

    public function read(Request $request)
    {
        $menuitem = MenuItem::find($request->id_menuitem);
        return response($menuitem);
    }

    public function deactivate(Request $request)
    {
        $menuitem = MenuItem::find($request->id_menuitem);
        $menuitem->update([
            'active' => 0
        ]);

        return response('delete success', 200);
    }
}
