<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\StatusHistory;
use App\Models\Task;
use App\Repositories\StatusRepositories;
use App\Repositories\WlmRepositories;
use Carbon\Carbon;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WlmKanbanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $request->flash();
        if(!$request->deadline){
            $obj =  Carbon::now()->format('Y');
            $request->request->add(['deadline' => $obj]);
        }
        if(!$request->ids_status){
            $obj = "confirmed,forecasted,pending";
            $request->request->add(['ids_status' => $obj]);
        }

        if(!$request->sortBy == "deadline"){
            $request->request->add(['sortBy' => 'deadline', 'order' => 'ASC']);
        }

        $result = WlmRepositories::getTasksWlmKanban($request);

        if ($request->ajax()) {
            return response()->json([
                'tasks' => $result['tasks'],
                'pagination' => $result['tasks']->links()->toHtml(),
                'countByStatus' => $result['countByStatus']
            ]);
        }
        return view('admin.wlm.kanban')->with([
            'tasks' => $result['tasks'],
            "allLocations" => Location::get(["name", "id_location"])
                ->map(fn ($location) => ["name" => $location->name, "location_id" => $location->id_location])
                ->toArray(),
            'tasksFilter' => json_encode($result['tasksFilter']),
            'statusConsultant' => StatusRepositories::getStatusConsultant(),
            'countByStatus' => json_encode($result['countByStatus'])
        ]);
    }

    public function updateStatusKanban(Request $request)
    {

        try {
            $statusH = StatusHistory::where(['element_id' => $request->id_task, 'id_status' => $request->id_status, 'active' => true])->get();
            foreach($statusH as $status){
                $status->update([
                    'active' => false
                ]);
            }
            $statusNew = StatusHistory::firstOrNew([
                'id_status' => $request->id_status,
                'element_id' => $request->id_task
            ]);
            $statusNew->active = true;
            $statusNew->exists ? $statusNew->update() : $statusNew->save();

            $response['id_task'] = $statusNew->element_id;
            $response['id_status'] = $statusNew->status->name;
            $response['message'] = 'Updated submission status';
            $response['status'] = true;

        } catch (\Throwable $th) {
            $response['message'] = $th->getMessage();
            $response['status'] = false;
        }

        return $response;
    }

    public function searchKanbanTasks(Request $request)
    {
        $result = WlmRepositories::getTasksWlmKanban($request);
        $tasks = $result['tasks'];
        $pagination = $tasks->links()->toHtml();

        return response()->json([
            'tasks' => $tasks,
            'pagination' => $pagination,
            'tasksFilter' => $result['tasksFilter'],
            'countByStatus' => $result['countByStatus']
        ]);
    }

    public function viewSubmission(Request $request)
    {
       $submission = Task::with('project', 'directory', 'guide', 'location', 'practice', 'project.client')->find($request->id)->toArray();
        $statusClient = DB::table('status_history')
            ->leftJoin('status', 'status_history.id_status', '=', 'status.id_status')
            ->select('status.name', 'status.html_color')
            ->where('status_history.element_id', $request->id)
            ->where('status_history.active', 1)
            ->where('status.element_type', 'task')
            ->where('status.status_type', 'client')
            ->orderBy('status_history.created_at', 'DESC')
            ->limit(1)
            ->first();

        $statusConsultant = DB::table('status_history')
            ->leftJoin('status', 'status_history.id_status', '=', 'status.id_status')
            ->select('status.name', 'status.html_color', 'status_history.description', 'status_history.created_at')
            ->where('status_history.element_id', $request->id)
            //->where('status_history.active', 1)
            ->where('status.element_type', 'task')
            ->where('status.status_type', 'consultant')
            ->orderBy('status_history.created_at', 'DESC')
            ->get()->toArray();

        $submission['status_client'] = $statusClient->name;
        $submission['status_client_color'] = $statusClient->html_color;
        $submission['statusConsultant'] = $statusConsultant;

        return view('admin.wlm.submission')->with([
            'submission' => $submission
        ]);
    }

}
