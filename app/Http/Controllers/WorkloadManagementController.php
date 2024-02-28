<?php

namespace App\Http\Controllers;

use App\Exports\TasksWlmExport;
use App\Models\Client;
use App\Models\Directory;
use App\Models\Group;
use App\Models\Guide;
use App\Models\Location;
use App\Models\Practice;
use App\Models\Product;
use App\Models\Role;
use App\Models\Status;
use App\Models\StatusHistory;
use App\Models\Task;
use App\Models\User;
use App\Repositories\ClientsRepositories;
use App\Repositories\DirectoriesRepositories;
use App\Repositories\GuidesRepositories;
use App\Repositories\LocationsRepositories;
use App\Repositories\PracticesRepositories;
use App\Repositories\ProductsRepositories;
use App\Repositories\StatusRepositories;
use App\Repositories\SubmissionsRepositories;
use App\Repositories\UsersRepositories;
use App\Repositories\WlmRepositories;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class WorkloadManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Load the WLM main view
     */
    public function index(Request $request)
    {


        $request->flash();
        /**
         * 1. Here we set all default filters
         */

        if(!$request->deadline){
            $obj =  Carbon::now()->format('Y');
            $request->request->add(['deadline' => $obj]);
        }
        if(!$request->ids_status){
            $obj = "confirmed,forecasted,pending";
            $request->request->add(['ids_status' => $obj]);
        }
        //deadline year
        if(!$request->sortBy == "deadline"){
            $request->request->add(['sortBy' => 'deadline', 'order' => 'ASC']);
        }

        //This function is called via ajax to retrieve paginated results
        if ($request->ajax()) {
            $request->request->add(['from' => true]);
            $result = WlmRepositories::getTasksWlm($request);
            $view = view('admin.items', ['tasks' => $result['tasks']])->render();
            $pagination =  $result['tasks']->links()->toHtml();


            return response()->json([
                'items'=>$result,
                'view' => $view,
                'pagination' => $pagination
            ]);
        }

        //this function is called the first time it loads.
        $result = WlmRepositories::getTasksWlm($request);
        $tasks = $result['tasks'];

        return view('admin.wlm.wlm-admin')->with([
            'tasks' => $tasks,
            "allLocations" => Location::get(["name", "id_location"])
                ->map(fn ($location) => ["name" => $location->name, "location_id" => $location->id_location])
                ->toArray(),
            'tasksGraph' => json_encode($result['tasksGraph']),
            'statusConsultant' => StatusRepositories::getStatusConsultant(),
            'scUsers'=> json_encode(UsersRepositories::getUsersSC()),
        ]);
    }

    /**
     * Updates status on WLM
     */
    public function updateStatusC(Request $request)
    {
        //Deactivates any previous status of the type CONSULTANT
        $statusH = StatusHistory::where('element_id', $request->id_task)
            ->when(
                Status::where("id_status", $request->id_status)->where("status_type", "consultant")->exists(),
                fn ($query) => $query->whereHas("status", function ( $query) {
                    $query->where('status_type', 'consultant');
                })
            )
            ->where('active', true)
            ->update(['active' => false]);
        //Saves new status
        $statusNew = StatusHistory::create([
            'id_status' => $request->id_status,
            'element_id' => $request->id_task,
            'description'=>$request->description,
            'active'=>true,
            'created_by'=>Auth::user()->id_user
        ]);


        //Prepares object to retunr data to client
        $task['id_task'] = $statusNew->element_id;
        $task['status_c'] = $statusNew->status->name;
        $task['status_description'] = $statusNew->description;
        $task['html_color'] = $statusNew->status->html_color;

        //Changed this to return json.
        $response['html'] = view('partials.td-popup')->with(['task' => $task])->render();
        $response['data'] = $task;

        return $response;
    }

    public function filterTasks(Request $request)
    {
        $request->request->add(['from' => true]);
        $result = WlmRepositories::getTasksWlm($request);
        $view = view('admin.items', ['tasks' => $result['tasks']])->render();
        $pagination =  $result['tasks']->links()->toHtml();

        return response()->json([
            'view' => $view,
            'pagination' => $pagination
        ]);
    }

    public function appendsFilters($tasks, $request)
    {
        if ($request->has('ids_client')) {
            $arrayValues = array_map('intval', explode(',', $request->get('ids_client')));
            $tasks->appends(['ids_client' => $arrayValues]);
        }
        if ($request->has('ids_directories')) {
            $tasks->appends(['ids_directories' => $request->get('ids_directories')]);
        }
        if ($request->has('ids_senior_consultant')) {
            $tasks->appends(['ids_senior_consultant' => $request->get('ids_senior_consultant')]);
        }
        if ($request->has('ids_coordinator')) {
            $tasks->appends(['ids_coordinator' => $request->get('ids_coordinator')]);
        }
        if ($request->has('year')) {
            $tasks->appends(['year' => $request->get('year')]);
        }
        if ($request->has('deadline')) {
            $tasks->appends(['deadline' => $request->get('deadline')]);
        }
        if ($request->has('ids_location')) {
            $tasks->appends(['ids_location' => $request->get('ids_location')]);
        }
        if ($request->has('ids_guide')) {
            $tasks->appends(['ids_guide' => $request->get('ids_guide')]);
        }
        if ($request->has('ids_consultant')) {
            $tasks->appends(['ids_consultant' => $request->get('ids_consultant')]);
        }
        if ($request->has('months')) {
            $tasks->appends(['months' => $request->get('months')]);
        }
        if ($request->has('ids_status')) {
            $tasks->appends(['ids_status' => $request->get('ids_status')]);
        }
        if ($request->has('ids_owner')) {
            $tasks->appends(['ids_owner' => $request->get('ids_owner')]);
        }
        if ($request->has('ids_lds')) {
            $tasks->appends(['ids_lds' => $request->get('ids_lds')]);
        }

        return $tasks;
    }

    public function searchTasks(Request $request)
    {
        $result = WlmRepositories::getTasksWlm($request);
        $tasks = $result['tasks'];
        $view = view('admin.items', ['tasks' => $tasks])->render();

        $pagination = $tasks->links()->toHtml();
        return response()->json([
            'view' => $view,
            'pagination' => $pagination,
            'tasksGraph' => $result['tasksGraph'],
            'totalTasks' => $tasks->total(),
        ]);
    }

    public function export(Request $request)
    {
        $result = WlmRepositories::getTasksWlm($request);
        return Excel::download(new TasksWlmExport($result['tasksGraph']), 'tasks.xlsx');
    }

}


