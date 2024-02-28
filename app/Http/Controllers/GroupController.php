<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupDetail;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GroupController extends Controller
{
    public function index()
    {
        return view('system-catalogs.groups')->with(['groups' => Group::where('deleted', 0)->get()]);
    }

    public function create()
    {
        return view('system-catalogs.group');
    }

    public function read(Request $request)
    {
        $group = Group::find($request->id);
        return view('system-catalogs.group')->with(['group' => $group]);
    }

    public function edit(Request $request)
    {
        $group = Group::find($request->id);
        return view('system-catalogs.group')->with(['group' => $group, 'section' => 'edit']);
    }

    public function save(Request $request)
    {
        $group = Group::findOrNew($request->id_group);
        $group->name = $request->name;
        $group->role = $request->role;
        $group->description = $request->description;

        $group->exists ? $group->update() : $group->save();

        return redirect()->route('read-group', ['id' => $group->id_group]);
    }

    public function saveUserGroup(Request $request)
    {
        $userExists = GroupDetail::where(['id_group' => $request->id_group,'id_user' => $request->id_user])->exists();
        if ($userExists && !isset($request->id_groupdetail)) {
            Session::flash('message', 'The user is already in the group.');
            Session::flash('type', 'error');
            Session::flash('title', 'Error');

            return back();
        }

        // if(isset($request->is_admin))
        // {
        //     $groupdetails = GroupDetail::where('id_group', $request->id_group)->get();
        //     foreach($groupdetails as $item)
        //     {
        //         $item->update(['is_admin' => null]);
        //     }
        // }

        $groupdetail = GroupDetail::findOrNew($request->id_groupdetail);
        $groupdetail->id_group = $request->id_group;
        $groupdetail->id_user = $request->id_user;
        $groupdetail->is_admin = $request->is_admin ? 1 : null;

        $groupdetail->exists ? $groupdetail->update() : $groupdetail->save();

        Session::flash('message', 'User saved successfully');
        Session::flash('type', 'success');
        Session::flash('title', 'Success');

        return redirect()->route('read-group', ['id' => $groupdetail->id_group]);
    }

    public function getGroupDetail(Request $request)
    {
        $groupdetail = GroupDetail::find($request->id_groupdetail);

        return response($groupdetail);
    }

    public function deactivate(Request $request)
    {
        $group = Group::find($request->id_group);
        foreach ($group->groupdetail as $groupD) {
            $groupD->delete();
        }
        $group->delete();
        $response['msj'] = 'Group deleted successfully';
        $response['status'] = 'success';

        return response($response);
    }

    public function deactivateGroupDetail(Request $request)
    {
        $groupD = GroupDetail::find($request->id_groupdetail);
        $groupD->delete();
        $response['msj'] = 'User deleted successfully';
        $response['status'] = 'success';

        return response($response);
    }

}
