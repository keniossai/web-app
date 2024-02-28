<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contact;
use App\Models\ContactRel;
use App\Models\Project;
use App\Models\Role;
use App\Repositories\UsersRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Image;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (UsersRepositories::isAdmin()) {
            $clients = Client::where('deleted', 0)->orderBy('name', 'ASC')->get();
        } else {
            $clients = Client::where(['owner' => Auth::user()->id_user, 'deleted' => 0])->orderBy('name', 'ASC')->get();
        }

        return view('admin.clients')->with(['clients' => $clients]);
    }

    public function create()
    {
        return view('admin.client')->with([
            'view' => 'create'
        ]);
    }

    public function read(Request $request)
    {
        $client = Client::find($request->id);
        return view('admin.client')->with([
            'client' => $client,
            'view' => $request->view == 'edit' ? 'edit' : 'read',
            'section' => $request->view,
        ]);
    }

    public function view(Request $request)
    {
        $client = Client::find($request->id);
        return view('admin.client')->with([
            'client' => $client,
            'view' => 'view',
            'section' => $request->view,
        ]);
    }

    public function save(Request $request)
    {
        $request->flash();
        if(isset($request->id_client)){//solo actualizar info wasRecentlyCreated
            $client = Client::findOrNew($request->id_client);
        } else { //nuevo
            $client = Client::firstOrCreate(['name' => $request->name, 'deleted' => 0]);
            if (!$client->wasRecentlyCreated) {// El usuario ya existe
                Session::flash('message', 'The client already exists');
                Session::flash('type', 'error');
                Session::flash('title', 'Warning');
                return back();
            }
        }
        $client->name = $request->name;
        $client->general_info = $request->general_info;
        $client->phone = $request->phone;
        $client->website = $request->website;
        $client->owner = $request->owner;
        $client->director = $request->director;

        $client->exists ? $client->update() : $client->save();

        if($request->hasFile('picture')){
            $path = public_path('files/clients/');
            $avatar = $request->file('picture');
            $filename =  'clt_'.time().'.'. $avatar->getClientOriginalExtension();
            Image::make($avatar)->save($path.$filename);

            $client->update([
                'picture' => $filename
            ]);
        }

        //Save contact
        if(isset($request->contact['name']) && isset($request->contact['last_name_contact']) && isset($request->contact['email']))
        {
            $contact = Contact::findOrNew($request->contact['id_contact']);
            $contact->name = $request->contact['name'];
            $contact->last_name = $request->contact['last_name_contact'];
            $contact->type = $request->contact['type_contact'];
            $contact->email = $request->contact['email'];
            $contact->phone = $request->contact['phone'];
            $contact->description = $request->contact['description_contact'];
            $contact->no_contact = isset($request->contact['no_contact']) && $request->contact['no_contact'] == "true" ? 1 : 0;
            $contact->created_by = Auth::user()->id_user;

            $contact->exists ? $contact->update() : $contact->save();

            ContactRel::firstOrCreate([
                'id_contact' => $contact->id_contact,
                'element_id' => $client->id_client,
                'type_rel' => 'marketing_business_development',
                'type_element' => 'client'
            ]);
        }

        Session::flash('message', 'Client saved successfully');
        Session::flash('type', 'success');
        Session::flash('title', 'Success');

        return redirect()->route('read-client', ['general', 'id' => $client->id_client]);
    }

    public function getClient(Request $request)
    {
        $client = Client::find($request->id_client);
        $client['url'] = $client->getPicture();

        return response($client);
    }

    public function delete(Request $request)
    {
        $client = Client::find($request->id_client);

        $project = Project::where([
            'id_client' => $client->id_client,
            'deleted' => 0
        ])->first();

        if(!isset($project)){
            $client->update([
                'deleted' => 1
            ]);

            $response['status'] = 1;
        } else {
            $response['status'] = 0;
        }

        return response($response, 200);
    }

    public function deletePicture(Request $request)
    {
        $client = Client::find($request->id_client);
        $response['status'] = 0;
        if (isset($client->picture) && file_exists(public_path() . '/files/clients/' .$client->picture)) {
            unlink('files/clients/'.$client->picture);

            $client->update([
                'picture' => null
            ]);
            $response['status'] = 1;
        }

        return response($response);
    }
}
