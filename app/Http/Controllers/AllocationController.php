<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Group;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use App\Repositories\DirectoriesRepositories;
use App\Repositories\GuidesRepositories;
use App\Repositories\LocationsRepositories;
use App\Repositories\PracticesRepositories;
use App\Repositories\ProductsRepositories;
use App\Repositories\StatusRepositories;
use App\Repositories\SubmissionsRepositories;
use App\Repositories\UsersRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AllocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $roles = Role::whereIn('id_role', function($query) {
            $query->select('id_role')
                ->from('user_role')
                ->where('id_user', Auth::user()->id_user);
        })->pluck('code');

        return view('admin.allocations')->with([
            'directories' => json_encode(DirectoriesRepositories::getDirectories()),
            'guides' => json_encode(GuidesRepositories::getGuides()),
            'locations' => json_encode(LocationsRepositories::getLocations()),
            'practices' => json_encode(PracticesRepositories::getPractices()),
            'clients' => DB::table('client')->select('id_client', 'name')->where(['deleted' => 0])->get()->toJson(),
            'products' => json_encode(ProductsRepositories::getProducts()),
            'scUsers'=> json_encode(UsersRepositories::getUsersSC()),
            'cUsers'=> json_encode(UsersRepositories::getUsersC()),
            'LDSUsers'=> json_encode(UsersRepositories::getUsersLDS()),
            'CoordUsers'=> json_encode(UsersRepositories::getUsersCoord()),
            'owners' => json_encode(UsersRepositories::getUsersForOwners()),
            'years' => json_encode(SubmissionsRepositories::getYearsTask()),
            'deadlines' => json_encode(SubmissionsRepositories::getDeadlineYearsTask()),
            'statuses' => json_encode(StatusRepositories::getAllStatus()),
            'ids_user' => UsersRepositories::usersGroup(),
            'roles' => $roles
        ]);
    }

    public function updateSubmissions(Request $request)
    {
        if(isset($request->filteredData) && count($request->filteredData)>0)
        {
            foreach($request->filteredData as $submission){
                $task = Task::findOrNew($submission['id_task']);
                $task->id_senior_consultant = $submission['id_senior_consultant'];
                $task->id_consultant = $submission['id_consultant'];
                $task->id_lds = $submission['id_lds'];
                $task->id_coordinator = $submission['id_coordinator'];
                $task->created_by = Auth::user()->id_user;

                $task->update();
            }

            $response['data'] = SubmissionsRepositories::getTasksForAllocation();

            return response($response);
        }
    }

    public function getTasks()
    {
        $response = SubmissionsRepositories::getTasksForAllocation();
        return response($response);
    }
}
