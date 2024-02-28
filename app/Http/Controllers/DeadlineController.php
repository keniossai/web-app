<?php

namespace App\Http\Controllers;

use App\Imports\DeadlineImport;
use App\Models\Deadline;
use App\Models\DeadlineHeader;
use App\Models\Task;
use App\Models\Taxonomy;
use App\Models\User;
use App\Repositories\GuidesRepositories;
use App\Repositories\LocationsRepositories;
use App\Repositories\PracticesRepositories;
use App\Repositories\TaxonomiesRepositories;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class DeadlineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.deadlines')->with([
            'deadlineheaders' => DeadlineHeader::where('deleted', 0)->get()
        ]);
    }

    public function create()
    {
        return view('admin.deadline')->with([
            'view' => 'create',
        ]);
    }

    public function read(Request $request)
    {
        $deadlineHeader =  DeadlineHeader::find($request->id);

        $deadlines = DB::table('taxonomy')
            ->leftJoin('deadline', function ($join) use ($deadlineHeader) {
                $join->on('taxonomy.id_guide', '=', 'deadline.id_guide');
                $join->on('taxonomy.id_location', '=', 'deadline.id_location');
                $join->on('taxonomy.id_practice', '=', 'deadline.id_practice');
                $join->on('deadline.deleted', '=', 'taxonomy.deleted');
                $join->Join('deadline_header', function ($join) {
                    $join->on('deadline.id_deadline_header', '=', 'deadline_header.id_deadline_header');
                })->where('deadline_header.year','=', $deadlineHeader->year);
            })
            ->leftJoin('guide', function($join){
                $join->on('deadline.id_guide', '=', 'guide.id_guide')
                ->orOn('taxonomy.id_guide', '=', 'guide.id_guide');
            })
            ->leftJoin('location', function($join){
                $join->on('deadline.id_location', '=', 'location.id_location')
                ->orOn('taxonomy.id_location', '=', 'location.id_location');
            })
            ->leftJoin('practice', function($join){
                $join->on('deadline.id_practice', '=', 'practice.id_practice')
                ->orOn('taxonomy.id_practice', '=', 'practice.id_practice');
            })
            ->where('taxonomy.id_directory', $deadlineHeader->id_directory)
            ->where('taxonomy.deleted', 0)
            ->orderByRaw('LEFT(guide.name, 1) asc')
            ->orderByRaw('LEFT(location.name, 1) asc')
            ->orderByRaw('LEFT(practice.name, 1) asc')
            ->orderBy('deadline.deadline', 'asc')
            ->select('deadline.id_deadline','deadline.id_deadline_header','deadline.deadline','deadline.confirmed','deadline.created_by','deadline.deleted', 'taxonomy.id_guide', 'taxonomy.id_location', 'taxonomy.id_practice',  'taxonomy.deleted')
            ->get();

        $idsGuide = collect($deadlines)->pluck('id_guide')->unique()->values()->all();
        $idsLocation = collect($deadlines)->pluck('id_location')->unique()->values()->all();
        $idsPractice = collect($deadlines)->pluck('id_practice')->unique()->values()->all();

        return view('admin.deadline')->with([
            'view' => $request->view,
            'deadlineheader' => $deadlineHeader,
            'guides' => json_encode(GuidesRepositories::getGuidesByDirectory($deadlineHeader->id_directory, $idsGuide)),
            'locations' => json_encode(LocationsRepositories::getLocationsOnlyIds($idsLocation)),
            'practices' => json_encode(PracticesRepositories::getPracticesByDirectory($deadlineHeader->id_directory, $idsPractice)),
            'deadlines' => $deadlines
        ]);
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year' => [
                'required',
                Rule::unique('deadline_header')->where(function ($query) use ($request) {
                    return $query->where('id_directory', $request->id_directory)->where('deleted', 0);
                })->ignore($request->id_deadline_header, 'id_deadline_header')
            ],
        ]);

        if ($validator->fails())
        {
            Session::flash('message', 'The deadline is already exists');
            Session::flash('type', 'error');
            Session::flash('title', 'Error');
            $request->flash(); // will display the current session entry

            return back();

        }else{
            $deadlineheader = DeadlineHeader::findOrNew($request->id_deadline_header);
            $deadlineheader->id_directory = $request->id_directory;
            $deadlineheader->year = $request->year;
            $deadlineheader->description = $request->description;
            $deadlineheader->created_by = Auth::user()->id_user;

            $deadlineheader->exists ? $deadlineheader->update() : $deadlineheader->save();

            Session::flash('message', 'Deadline header saved successfully');
            Session::flash('type', 'success');
            Session::flash('title', 'Success');

            return redirect()->route('read-deadlineheader', ['edit', 'id' => $deadlineheader->id_deadline_header]);
        }
    }

    public function saveDeadline(Request $request)
    {
        $deadlineHeader = DeadlineHeader::find($request->id_deadline_header);
        if(isset($request->filteredData) && count($request->filteredData)>0)
        {

            foreach($request->filteredData as $item){
                $deadline = Deadline::findOrNew($item['id_deadline']);
                $deadline->id_deadline_header = $deadlineHeader->id_deadline_header;
                $deadline->id_guide = $item['id_guide'];
                $deadline->id_location = $item['id_location'];
                $deadline->id_practice = $item['id_practice'];
                $deadline->deadline = isset($item['deadline']) ? $item['deadline'] : null;
                $deadline->confirmed = (isset($item['confirmed']) && $item['confirmed'] != false) ? 1 : 0;
                $deadline->created_by = Auth::user()->id_user;

                $deadline->exists ? $deadline->update() : $deadline->save();
            }
        }

        if(isset($request->ids_deadline)){
            foreach($request->ids_deadline as $id){
                $deadline = Deadline::find($id);
                $deadline->update([
                    'deleted' => 1
                ]);
            }
        }

        $deadlines = DB::table('taxonomy')
            ->leftJoin('deadline', function ($join) use ($deadlineHeader) {
                $join->on('taxonomy.id_guide', '=', 'deadline.id_guide');
                $join->on('taxonomy.id_location', '=', 'deadline.id_location');
                $join->on('taxonomy.id_practice', '=', 'deadline.id_practice');
                $join->on('deadline.deleted', '=', 'taxonomy.deleted');
                $join->Join('deadline_header', function ($join) {
                    $join->on('deadline.id_deadline_header', '=', 'deadline_header.id_deadline_header');
                })->where('deadline_header.year','=', $deadlineHeader->year);
            })
            ->leftJoin('guide', function($join){
                $join->on('deadline.id_guide', '=', 'guide.id_guide')
                ->orOn('taxonomy.id_guide', '=', 'guide.id_guide');
            })
            ->leftJoin('location', function($join){
                $join->on('deadline.id_location', '=', 'location.id_location')
                ->orOn('taxonomy.id_location', '=', 'location.id_location');
            })
            ->leftJoin('practice', function($join){
                $join->on('deadline.id_practice', '=', 'practice.id_practice')
                ->orOn('taxonomy.id_practice', '=', 'practice.id_practice');
            })
            ->where('taxonomy.id_directory', $deadlineHeader->id_directory)
            ->where('taxonomy.deleted', 0)
            ->orderByRaw('LEFT(guide.name, 1) asc')
            ->orderByRaw('LEFT(location.name, 1) asc')
            ->orderByRaw('LEFT(practice.name, 1) asc')
            ->orderBy('deadline.deadline', 'asc')
            ->select('deadline.id_deadline','deadline.id_deadline_header','deadline.deadline','deadline.confirmed','deadline.created_by','deadline.deleted', 'taxonomy.id_guide', 'taxonomy.id_location', 'taxonomy.id_practice',  'taxonomy.deleted')
            ->get();

        $response['data'] = $deadlines;

        return response($response);
    }

    public function deleteDeadline(Request $request)
    {
        $deadlineHeader = DeadlineHeader::find($request->id_deadline_header);
        $deadlines = Deadline::where(['id_deadline_header' => $deadlineHeader->id_deadline_header, 'deleted' => 0 ])->get();
        foreach($deadlines as $deadline){
            $deadline->update([
                'deleted' => 1
            ]);
        }

        $deadlineHeader->update([
            'deleted' => 1
        ]);

        return response('success deleted');
    }

    public function fileUploadDeadline(Request $request)
    {
        $status = [];
        try {
            Excel::import(new DeadlineImport, $request->file('file')->store('temp'));
            $status['status'] = true;
            $status['message'] = "Uploaded successfully";
        } catch (\Throwable $th) {
            $status['status'] = false;
            $status['message'] = "Check that the dates have the correct format (day/month/year)";
        }

        return response($status);
    }

    public function getDeadlinesByHeader(Request $request)
    {
        $deadlines = Deadline::where([
            'id_deadline_header' => $request->id_deadline_header,
            'deleted' => 0
        ])->whereNotNull('deadline')->count();

        return response($deadlines);
    }

    public function updateDeadlineSubmission(Request $request)
    {
        $deadlineHeader = DeadlineHeader::find($request->id_deadline_header);
        $response = [];
        try {
            $deadlines = DB::table('task')
                ->leftJoin('deadline', function ($join) {
                    $join->on('task.id_guide', '=', 'deadline.id_guide');
                    $join->on('task.id_location', '=', 'deadline.id_location');
                    $join->on('task.id_practice', '=', 'deadline.id_practice');
                })
                ->Join('deadline_header', function ($join) {
                    $join->on('deadline_header.id_directory', '=', 'task.id_directory');
                    $join->on('deadline.id_deadline_header', '=', 'deadline_header.id_deadline_header');
                })
                ->Join('project', function ($join) {
                    $join->on('task.id_project', '=', 'project.id_project');
                    $join->on('project.year', '=', 'deadline_header.year');
                })
                ->where('deadline.id_deadline_header', $deadlineHeader->id_deadline_header)
                ->whereNotNull('deadline.deadline')
                ->where('deadline.deleted', 0)
                ->select('task.*', 'deadline.deadline', 'deadline.confirmed', 'project.agreed_deadline as agreedDeadline')
                ->get();

            foreach($deadlines as $deadline)
            {
                $task = Task::find($deadline->id_task);
                if($deadline->agreedDeadline == 1){
                    $task->update([
                        'deadline' => $deadline->deadline,
                        'confirmed' => $deadline->confirmed
                    ]);
                } else {
                    $task->update([
                        'deadline' => $deadline->deadline,
                        'agreed_deadline' => $deadline->deadline,
                        'confirmed' => $deadline->confirmed
                    ]);
                }

            }
            $response['status'] = true;
            $response['message'] = 'Submission update successfully';
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
        }

       return response($response);
    }

    public function todayUpdateDeadlineSubmission(Request $request)
    {
        $deadlineHeader = DeadlineHeader::find($request->id_deadline_header);
        $response = [];
        try {
            $deadlines = DB::table('task')
                ->leftJoin('deadline', function ($join) {
                    $join->on('task.id_guide', '=', 'deadline.id_guide');
                    $join->on('task.id_location', '=', 'deadline.id_location');
                    $join->on('task.id_practice', '=', 'deadline.id_practice');
                })
                ->Join('deadline_header', function ($join) {
                    $join->on('deadline_header.id_directory', '=', 'task.id_directory');
                    $join->on('deadline.id_deadline_header', '=', 'deadline_header.id_deadline_header');
                })
                ->Join('project', function ($join) {
                    $join->on('task.id_project', '=', 'project.id_project');
                    $join->on('project.year', '=', 'deadline_header.year');
                })
                ->where('deadline.id_deadline_header', $deadlineHeader->id_deadline_header)
                ->whereNotNull('deadline.deadline')
                ->where('deadline.deleted', 0)
                ->whereDate('deadline.updated_at', Carbon::today())
                ->select('task.*', 'deadline.deadline', 'deadline.confirmed', 'project.agreed_deadline as agreedDeadline')
                ->get();

            foreach($deadlines as $deadline)
            {
                $task = Task::find($deadline->id_task);
                if($deadline->agreedDeadline == 1){
                    $task->update([
                        'deadline' => $deadline->deadline,
                        'confirmed' => $deadline->confirmed
                    ]);
                } else {
                    $task->update([
                        'deadline' => $deadline->deadline,
                        'agreed_deadline' => $deadline->deadline,
                        'confirmed' => $deadline->confirmed
                    ]);
                }
            }
            $response['status'] = true;
            $response['message'] = 'Submission update successfully';
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['message'] = $th->getMessage();
        }

       return response($response);
    }
}
