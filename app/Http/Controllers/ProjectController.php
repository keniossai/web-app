<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contact;
use App\Models\ContactRel;
use App\Models\Directory;
use App\Models\Guide;
use App\Models\Location;
use App\Models\Practice;
use App\Models\Project;
use App\Models\Role;
use App\Models\Status;
use App\Models\StatusHistory;
use App\Models\Task;
use App\Models\Taxonomy;
use App\Repositories\ContactsRepositories;
use App\Repositories\DirectoriesRepositories;
use App\Repositories\GuidesRepositories;
use App\Repositories\LocationsRepositories;
use App\Repositories\PracticesRepositories;
use App\Repositories\ProductsRepositories;
use App\Repositories\ProjectRepositories;
use App\Repositories\StatusRepositories;
use App\Repositories\TaxonomiesRepositories;
use App\Repositories\SubmissionsRepositories;
use App\Repositories\UsersRepositories;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(UsersRepositories::isAdmin()){
            $projects = Project::where('project.deleted', 0)->orderBy('project.name', 'ASC')
                ->leftJoin('client', function($join){
                    $join->on('project.id_client', '=', 'client.id_client');
                })
                ->leftJoin('product', function($join){
                    $join->on('project.id_product', '=', 'product.id_product');
                })
                ->leftJoin('user', function($join){
                    $join->on('project.owner', '=', 'user.id_user');
                })
                ->leftJoin('contact', function($join){
                    $join->on('user.id_user', '=', 'contact.id_user');
                })
                ->select('project.id_project', 'project.name as projectName', 'client.name as clientName', 'product.name as productName', 'project.year', DB::raw("CONCAT(contact.name, ' ', contact.last_name) AS ownerName"))
                ->get()->toArray();
        } else {
            $projects = Project::where(['project.owner' => Auth::user()->id_user, 'project.deleted' => 0])->orderBy('project.name', 'ASC')
            ->leftJoin('client', function($join){
                $join->on('project.id_client', '=', 'client.id_client');
            })
            ->leftJoin('product', function($join){
                $join->on('project.id_product', '=', 'product.id_product');
            })
            ->leftJoin('user', function($join){
                $join->on('project.owner', '=', 'user.id_user');
            })
            ->leftJoin('contact', function($join){
                $join->on('user.id_user', '=', 'contact.id_user');
            })
            ->select('project.id_project', 'project.name as projectName', 'client.name as clientName', 'product.name as productName', 'project.year', DB::raw("CONCAT(contact.name, ' ', contact.last_name) AS ownerName"))
            ->get()->toArray();
        }

        return view('admin.projects')->with(['projects' => $projects]);
    }

    public function create()
    {
        return view('admin.project')->with([
            'view' => 'create',
        ]);
    }

    public function read(Request $request)
    {
        $isview = false;
        $project = ProjectRepositories::getProject($request->id);

        $tasks = SubmissionsRepositories::getTasks($request->id);
        $directories = json_encode(DirectoriesRepositories::getDirectories());
        $guides = json_encode(GuidesRepositories::getGuides());
        $locations = json_encode(LocationsRepositories::getLocations());
        $practices = json_encode(PracticesRepositories::getPractices());
        $products = json_encode(ProductsRepositories::getProducts());
        $taxonomies = TaxonomiesRepositories::getTaxonomiesSpecials();
        $contacts = json_encode(ContactsRepositories::getContactsPBD($project));
        $contactsByClient = json_encode(ContactsRepositories::getContactsByClient($project));
        $statusClient = json_encode(StatusRepositories::getStatusForClient());

        if($request->view == 'contacts'){
            return view('admin.project-contacts')->with([
                'isView' => false,
                'view' => $request->view,
                'project' => $project,
                'tasks' => $tasks->toJson(),
                'directories' => $directories,
                'guides' => $guides,
                'locations' => $locations,
                'practices' => $practices,
                'products' => $products,
                'taxonomies' => $taxonomies,
                'contacts' => $contacts,
                'contactsByClient' => $contactsByClient,
                'tasksCount' => $tasks->count()
            ]);
        }
        if($request->view == 'view'){
            $isview = true;
        }

        return view('admin.project')->with([
            'isView' => $isview,
            'view' => $request->view,
            'project' => $project,
            'tasks' => $tasks->toJson(),
            'directories' => $directories,
            'guides' => $guides,
            'locations' => $locations,
            'practices' => $practices,
            'products' => $products,
            'taxonomies' => $taxonomies,
            'contacts' => $contacts,
            'contactsByClient' => $contactsByClient,
            'statusClient' => $statusClient,
            'tasksCount' => $tasks->count()
        ]);
    }

    public function view(Request $request)
    {
        $project = ProjectRepositories::getProject($request->id);
        $tasks = SubmissionsRepositories::getTasks($request->id);
        $directories = json_encode(DirectoriesRepositories::getDirectories());
        $guides = json_encode(GuidesRepositories::getGuides());
        $locations = json_encode(LocationsRepositories::getLocations());
        $practices = json_encode(PracticesRepositories::getPractices());
        $products = json_encode(ProductsRepositories::getProducts());
        $taxonomies = TaxonomiesRepositories::getTaxonomiesSpecials();
        $contacts = json_encode(ContactsRepositories::getContactsPBD($project));
        $contactsByClient = json_encode(ContactsRepositories::getContactsByClient($project));
        $statusClient = json_encode(StatusRepositories::getStatusForClient());
        if($request->view == 'contacts'){
            return view('admin.project-contacts')->with([
                'isView' => true,
                'view' => $request->view,
                'project' => $project,
                'tasks' => $tasks->toJson(),
                'directories' => $directories,
                'guides' => $guides,
                'locations' => $locations,
                'practices' => $practices,
                'products' => $products,
                'taxonomies' => $taxonomies,
                'contacts' => $contacts,
                'contactsByClient' => $contactsByClient,
                'tasksCount' => $tasks->count()
            ]);
        }

        return view('admin.project')->with([
            'isView' => true,
            'view' =>  $request->view,
            'project' => $project,
            'tasks' => $tasks->toJson(),
            'directories' => $directories,
            'guides' => $guides,
            'locations' => $locations,
            'practices' => $practices,
            'products' => $products,
            'taxonomies' => $taxonomies,
            'contacts' => $contacts,
            'contactsByClient' => $contactsByClient,
            'statusClient' => $statusClient,
            'tasksCount' => $tasks->count()
        ]);

    }

    public function save(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:100',
                Rule::unique('project')->where(function ($query) {
                    return $query->where('deleted', 0);
                })->ignore($request->id_project, 'id_project')
            ],
        ]);

        if (!$validator->fails()) {
            $project = Project::findOrNew($request->id_project);
            $project->name = $request->name;
            $project->id_client = $request->id_client;
            $project->id_product = $request->id_product;
            $project->year = $request->year;
            $project->owner = $request->owner;
            $project->description = $request->description;
            $project->agreed_deadline = isset($request->agreed_deadline) ? $request->agreed_deadline : 0;
            $project->exists ? $project->update() : $project->save();

            Session::flash('message', 'Project saved successfully');
            Session::flash('type', 'success');
            Session::flash('title', 'Success');

            return redirect()->route('read-project', ['submissions', 'id' => $project->id_project]);
        } else {
            $failedRules = $validator->failed();
            if(isset($failedRules['name']['Unique'])){
                Session::flash('message', 'The project name is already exists');
            } else if(isset($failedRules['name']['Max'])){
                // retrieve errors message bag
                Session::flash('message', $validator->getMessageBag()->first());
            }

            Session::flash('type', 'error');
            Session::flash('title', 'Error');
            $request->flash();
            return back();
        }
    }


    public function saveUpdateSubmissions(Request $request)
    {
        if(isset($request->filteredData) && count($request->filteredData)>0)
        {
            foreach($request->filteredData as $submission){
                $task = Task::findOrNew($submission['id_task']);
                $task->name = $request->name;
                $task->year = $request->year;
                $task->id_project = $request->id_project;
                $task->id_product = $submission['id_product'];
                $task->id_directory = $submission['id_directory'];
                $task->id_guide = $submission['id_guide'];
                $task->id_location = $submission['id_location'];
                $task->id_practice = $submission['id_practice'];
                $task->deadline = isset($submission['deadline']) ? $submission['deadline'] : null;
                $task->agreed_deadline = isset($submission['agreed_deadline']) ? $submission['agreed_deadline'] : null;
                $task->created_by = Auth::user()->id_user;
                // $task->confirmed = isset($submission['confirmed']) ? $submission['confirmed'] : 0;

                $exists = $task->exists;

                $task->exists ? $task->update() : $task->save();

                if(isset($submission['ids_contact'])){
                    $getContactsRel = ContactRel::where([
                        'element_id' => $task->id_task,
                        'type_rel' => 'marketing_business_development',
                        'type_element' => 'task'
                        ])->whereNotIn('id_contact',$submission['ids_contact'])->get();
                    foreach($getContactsRel as $contactRelDel)
                    {
                        $contactRelDel->update([
                            'deleted' => 1
                        ]);
                    }

                    foreach($submission['ids_contact'] as $idC){
                        $contactRel = ContactRel::firstOrNew([
                            'element_id' => $task->id_task,
                            'type_rel' => 'marketing_business_development',
                            'type_element' => 'task',
                            'id_contact' => $idC
                        ]);
                        $contactRel->deleted = 0;
                        $contactRel->exists ? $contactRel->update() : $contactRel->save();
                    }
                }

                if(isset($submission['id_status'])){
                    $statusH = StatusHistory::where([
                        'element_id' => $task->id_task,
                        'active' => true
                        ])->where('id_status', '<>', $submission['id_status'])->get();

                    // The previous returns a value, it means that the new status is different
                    foreach($statusH as $status){
                        $status->update([
                            'active' => false
                        ]);
                    }

                    //This finds a record to update or create a new one
                    $statusNew = StatusHistory::firstOrNew([
                        'id_status' => $submission['id_status'],
                        'element_id' => $task->id_task
                    ]);
                    $statusNew->description = $submission['description'];
                    $statusNew->active = true;
                    $statusNew->exists ? $statusNew->update() : $statusNew->save();

                }

                // Added creation of a new status
                if(!$exists){
                    $statusNew = StatusHistory::firstOrNew([
                        'id_status' => 28,
                        'element_id' => $task->id_task
                    ]);
                    $statusNew->description = 'Added to a projects';
                    $statusNew->active = true;
                    $statusNew->exists ? $statusNew->update() : $statusNew->save();
                }
            }
        }
         //delete
        if(isset($request->ids_submission)){
            foreach($request->ids_submission as $id){
                $task = Task::find($id);

                $task->update([
                    'deleted' => 1
                ]);

                if(($task->statushistory->first() != null)){
                    $statusNew = StatusHistory::where([
                        'id_status' => $task->statushistory->first()->id_status,
                        'element_id' => $task->id_task
                    ])->get()->first();

                    $statusNew->active = false;
                    $statusNew->update();
                }

                $contactRel = ContactRel::where([
                    'element_id' => $task->id_task,
                    'type_rel' => 'marketing_business_development',
                    'type_element' => 'task',
                ])->first();

                if(isset($contactRel))
                {
                    $contactRel->update([
                        'deleted' => 1
                    ]);
                }
            }
        }


        $response['data'] = SubmissionsRepositories::getTasks($request->id_project);

        return response($response);
    }



    public function getGuidesFromTaxonomy(Request $request)
    {
        $ids_guide = Taxonomy::where(['id_directory' => $request->id_directory, 'deleted' => 0])->pluck('id_guide');
        $guides = DB::table('guide')
            ->select(
                'id_guide',
                'name'
            )
            ->whereIn('id_guide', $ids_guide)
            ->where('deleted', 0)
            ->orderByRaw('LEFT(name, 3) asc')
            ->get();

        return view('partials.guide')->with(['guides' => $guides]);
    }

    public function getLocationsFromTaxonomy(Request $request)
    {
        $ids_location = Taxonomy::where(['id_directory' => $request->id_directory, 'id_guide' => $request->id_guide, 'deleted' => 0])->pluck('id_location');
        $location = Location::whereIn('id_location', $ids_location)->orderBy('name')->where('deleted', 0)->get();

        return view('partials.location')->with(['locations' => $location]);
    }

    public function getPracticesFromTaxonomy(Request $request)
    {
        $ids_practice = Taxonomy::where(['id_directory' => $request->id_directory, 'id_guide' => $request->id_guide, 'id_location' => $request->id_location, 'deleted' => 0])->pluck('id_practice');
        $practices = Practice::whereIn('id_practice', $ids_practice)->where('deleted', 0)->orderBy('name')->get();

        return view('partials.practice')->with(['practices' => $practices]);
    }

    public function deleteProject(Request $request)
    {
        $tasks = Task::where('id_project', $request->id_project)->get();

        foreach($tasks as $task)
        {
            $task->update([
                'deleted' => 1
            ]);

            $statusHistory = StatusHistory::where([
                'element_id' => $task->id_task
            ])->get();

            foreach($statusHistory as $status)
            {
                $status->update([
                    'active' => false
                ]);
            }
        }

        $project = Project::find($request->id_project);

        $project->update([
            'deleted' => 1
        ]);

        return response('success', 200);
    }

    public function getDirectoriesFromTaxonomy()
    {
        $ids_directory = Taxonomy::where(['deleted' => 0])->pluck('id_directory');
        $directories = Directory::whereIn('id_directory', $ids_directory)->where('deleted', 0)->orderBy('name')->get();

        return view('partials.directory')->with(['directories' => $directories]);
    }

    public function getCatalogTaxonomies()
    {
        $response['directories'] = DirectoriesRepositories::getDirectories();
        $response['guides'] = GuidesRepositories::getGuides();
        $response['locations'] = LocationsRepositories::getLocations();
        $response['practices'] = PracticesRepositories::getPractices();
        $response['taxonomies'] = json_decode(TaxonomiesRepositories::getTaxonomiesSpecials(), true);

        return response($response, 200);
    }

    public function saveContact(Request $request)
    {
        $contact = Contact::findOrNew($request->id_contact);
        $contact->name = $request->name;
        $contact->last_name = $request->last_name;
        $contact->type = $request->type;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->description = $request->description;
        $contact->no_contact = $request->no_contact == "true" ? 1 : 0;
        $contact->created_by = Auth::user()->id_user;

        $contact->exists ? $contact->update() : $contact->save();

        ContactRel::firstOrCreate([
            'id_contact' => $contact->id_contact,
            'element_id' => $request->id_client,
            'type_rel' => 'marketing_business_development',
            'type_element' => 'client'
        ]);

        ContactRel::firstOrCreate([
            'id_contact' => $contact->id_contact,
            'element_id' => $request->id_project,
            'type_rel' => 'marketing_business_development',
            'type_element' => 'project',
            'deleted' => 0
        ]);

        return response('success', 200);
    }

    public function editContact(Request $request)
    {
        $contact = Contact::find($request->id_contact);
        return response($contact);
    }

    public function deleteContact(Request $request)
    {
        $contact = Contact::find($request->id_contact);
        $contact->update([
            'deleted' => 1
        ]);

        return response('success');
    }

    public function getDealineDirectory(Request $request)
    {
        $deadline = DB::table('deadline')
            ->Join('deadline_header', function ($join) {
                $join->on('deadline.id_deadline_header', '=', 'deadline_header.id_deadline_header');
            })
            ->where('deadline_header.id_directory', $request->id_directory)
            ->where('deadline.id_guide', $request->id_guide)
            ->where('deadline.id_location', $request->id_location)
            ->where('deadline.id_practice', $request->id_practice)
            ->where('deadline_header.year', $request->year)
            ->where('deadline.confirmed', 1)
            ->whereNotNull('deadline.deadline')
            ->where('deadline.deleted', 0)
            ->select('deadline.deadline')
            ->get();

        return response($deadline);
    }

    public function deleteContactRel(Request $request)
    {
        $contactRel = ContactRel::where([
            'id_contact' => $request->id_contact,
            'type_element' => $request->type_element,
            'element_id' => $request->id_project
        ])->first();

        $project = Project::find($request->id_project);
        $ids_submission = $project->task->filter(function ($item){
            return $item->deleted == 0;
        })->pluck('id_task');

        $contactRelQty = ContactRel::whereIn('element_id', $ids_submission)->where([
            'id_contact' => $request->id_contact,
            'type_element' => 'task',
            'deleted' => 0
        ])->count();

        $response['status'] = 0;

        if($contactRelQty > 0)
        {
            $response['message'] = 'It is not possible to delete the contact, it is assigned to a submission';
        } else {
            $contactRel->update([
                'deleted' => 1
            ]);
            $response['message'] = 'Contact deleted successfully';
            $response['status'] = 1;
        }

        return response($response);
    }

    public function getSubmission(Request $request)
    {
        $project = ProjectRepositories::getProject($request->id_project);
        $currentProject = ProjectRepositories::getProject($request->id_project_current);
        $status  = Status::where(['element_type' => 'task', 'status_type' => 'consultant', 'deleted' => 0, 'name' => 'forecasted'])->first();
        $tasks = Task::where(['id_project' => $project->id_project, 'deleted' => 0])->get()->map(function($task) use ($currentProject, $status){
            $task['action'] = "insert";
            $task['id_project'] = $currentProject->id_project;
            $task['name'] = $currentProject->name;
            $task['id_product'] = $currentProject->id_product;
            $contacts = DB::table('contact_rel')
                ->select(
                    'contact.id_contact',
                    DB::raw("CONCAT(contact.name, ' ', contact.last_name) as name")
                )
                ->leftJoin('contact', 'contact_rel.id_contact', '=', 'contact.id_contact')
                ->where([
                    'contact_rel.type_element' => 'task',
                    'contact_rel.type_rel' => 'marketing_business_development',
                    'contact_rel.element_id' => $task->id_task,
                    'contact_rel.deleted' => 0,
                    'contact.deleted' => 0
                ])
                ->orderByRaw('LEFT(name, 2) asc')
                ->get();

            $task['ids_contact'] =  $contacts->pluck('id_contact')->toArray();
            $task['contact_names'] = implode(', ', $contacts->pluck('name')->toArray());
            $task['description'] = 'Initial status of the use of the template';
            $task['id_status'] = $status->id_status;
            $task['id_task'] = null;

            $deadline = DB::table('deadline')
                ->Join('deadline_header', function ($join) {
                    $join->on('deadline.id_deadline_header', '=', 'deadline_header.id_deadline_header');
                })
                ->where('deadline_header.id_directory', $task->id_directory)
                ->where('deadline.id_guide', $task->id_guide)
                ->where('deadline.id_location', $task->id_location)
                ->where('deadline.id_practice', $task->id_practice)
                ->where('deadline_header.year', $currentProject->year)
                ->where('deadline.confirmed', 1)
                ->whereNotNull('deadline.deadline')
                ->where('deadline.deleted', 0)
                ->select('deadline.deadline')
                ->get()->first();

            $task['deadline'] = isset($deadline->deadline) ? $deadline->deadline : $task->deadline;

            return $task;
        });
        return response($tasks);
    }
}
