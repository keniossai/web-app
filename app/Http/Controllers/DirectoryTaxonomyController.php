<?php

namespace App\Http\Controllers;

use App\Models\CentralPractice;
use App\Models\Directory;
use App\Models\Guide;
use App\Models\Location;
use App\Models\Practice;
use App\Models\RelLocationGuide;
use App\Models\Task;
use App\Models\Taxonomy;
use App\Repositories\DirectoriesRepositories;
use App\Repositories\GuidesRepositories;
use App\Repositories\LocationsRepositories;
use App\Repositories\PracticesRepositories;
use App\Repositories\TaxonomiesRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DirectoryTaxonomyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('catalogs.directory-taxonomy')->with([
            'taxonomies' => TaxonomiesRepositories::getTaxonomiesSpecials(),
            'directories' => json_encode(DirectoriesRepositories::getDirectories()),
            'guides' => json_encode(GuidesRepositories::getGuides()),
            'locations' => json_encode(LocationsRepositories::getLocations()),
            'practices' => json_encode(PracticesRepositories::getPractices())
        ]);
    }

    public function saveDirectory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('directory')->where(function ($query) {
                    return $query->where('deleted', 0);
                })->ignore($request->id_directory, 'id_directory')
            ],
        ]);

        if ($validator->fails())
        {
            $response['status'] = 1;
            return response($response);
        }

        $directory = Directory::findOrNew($request->id_directory);
        $directory->name = $request->name;
        $directory->description = $request->description;
        $directory->created_by = Auth::user()->id_user;

        $directory->exists ? $directory->update() : $directory->save();

        return view('partials.directory')->with(['directories' => Directory::where('deleted', 0)->get(), 'previous_id_directory' => $directory->id_directory]);
    }

    public function getDirectory(Request $request)
    {
        $directory = Directory::find($request->id_directory);

        return response($directory, 200);
    }

    public function saveGuide(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('guide')->where(function ($query) use ($request) {
                    return $query->where('id_directory', $request->id_directory)->where('deleted', 0);
                })->ignore($request->id_guide, 'id_guide')
            ],
        ]);

        if ($validator->fails())
        {
            $response['status'] = 1;
            return response($response);
        }

        $guide = Guide::findOrNew($request->id_guide);
        $guide->id_directory = $request->id_directory;
        $guide->name = $request->name;
        $guide->description = $request->description;
        $guide->created_by = Auth::user()->id_user;

        $guide->exists ? $guide->update() : $guide->save();

        return view('partials.guide')->with(['guides' => Guide::where(['id_directory' => $guide->id_directory, 'deleted' => 0])->get(), 'previous_id_guide' => $guide->id_guide]);
    }

    public function getGuide(Request $request)
    {
        $guide = Guide::find($request->id_guide);

        return response($guide, 200);
    }

    public function getGuidesByDirectory(Request $request)
    {
        $guides = Guide::where(['id_directory' => $request->id_directory, 'deleted' => 0])->orderBy('name')->get();

        return view('partials.guide')->with(['guides' => $guides]);
    }

    public function getPracticesByDirectory(Request $request)
    {
        $practices = Practice::where(['id_directory' => $request->id_directory, 'deleted' => 0])->orderBy('name')->get();

        return view('partials.practice')->with(['practices' => $practices]);
    }

    public function saveLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('location')->where(function ($query) {
                    return $query->where('deleted', 0);
                })->ignore($request->id_location, 'id_location')
            ],
        ]);

        if ($validator->fails())
        {
            $response['status'] = 1;
            return response($response);
        }

        $location = Location::findOrNew($request->id_location);
        $location->name = $request->name;
        $location->description = $request->description;
        $location->lat = $request->lat;
        $location->long = $request->long;
        $location->created_by = Auth::user()->id_user;

        $location->exists ? $location->update() : $location->save();

        return view('partials.location')->with(['locations' => Location::where('deleted', 0)->get(), 'previous_id_location' => $location->id_location]);
    }

    public function getLocation(Request $request)
    {
        $location = Location::find($request->id_location);

        return response($location, 200);
    }

    public function savePractice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('practice')->where(function ($query) use ($request) {
                    return $query->where('id_directory', $request->id_directory)->where('deleted', 0);
                })->ignore($request->id_practice, 'id_practice')
            ],
        ]);

        if ($validator->fails())
        {
            $response['status'] = 1;
            return response($response);
        }
        $centralP = CentralPractice::findOrNew($request->id_central_practice);
        if(!$centralP->exists){
            $centralP->name = $request->id_central_practice;
            $centralP->created_by = Auth::user()->id_user;

            $centralP->save();
        }

        $practice = Practice::findOrNew($request->id_practice);
        $practice->id_central_practice = $centralP->id_central_practice;
        $practice->id_directory = $request->id_directory;
        $practice->name = $request->name;
        $practice->created_by = Auth::user()->id_user;

        $practice->exists ? $practice->update() : $practice->save();

        return view('partials.practice')->with(['practices' => Practice::where(['id_directory' => $practice->id_directory, 'deleted' => 0])->get(), 'previous_id_practice' => $practice->id_practice]);
    }

    public function getPractice(Request $request)
    {
        $practice = Practice::find($request->id_practice);

        return response($practice, 200);
    }

    public function saveAllDirectoryTaxonomy(Request $request)
    {
        if(isset($request->filteredData) && count($request->filteredData)>0)
        {
            foreach($request->filteredData as $directoryTaxonomy){
                $taxonomy = Taxonomy::findOrNew($directoryTaxonomy['id_taxonomy']);
                $taxonomy->id_directory = $directoryTaxonomy['id_directory'];
                $taxonomy->id_guide = $directoryTaxonomy['id_guide'];
                $taxonomy->id_location = $directoryTaxonomy['id_location'];
                $taxonomy->id_practice = $directoryTaxonomy['id_practice'];
                $taxonomy->created_by = Auth::user()->id_user;

                $taxonomy->exists ? $taxonomy->update() : $taxonomy->save();

            }
        }

         //delete
         if(isset($request->ids_taxonomy)){
            foreach($request->ids_taxonomy as $id){
                $user = Taxonomy::find($id);
                $user->update([
                    'deleted' => 1
                ]);
            }
        }

        $response['data'] = Taxonomy::where(['deleted' => 0])->get();

        return response($response);

    }

    public function deleteDirectory(Request $request)
    {
        $directory = Directory::find($request->id_directory);

        $taxonomies = Taxonomy::where('id_directory', $directory->id_directory)->get();
        foreach($taxonomies as $taxonomy)
        {
            $taxonomy->update([
                'deleted' => 1
            ]);
        }

        $tasks = Task::where('id_directory', $directory->id_directory)->get();
        foreach($tasks as $task)
        {
            $task->update([
                'deleted' => 1
            ]);
        }

        $guides = Guide::where('id_directory', $directory->id_directory)->get();
        foreach($guides as $guide)
        {
            $guide->update([
                'deleted' => 1
            ]);
        }

        $practices = Practice::where('id_directory', $directory->id_directory)->get();
        foreach($practices as $practice)
        {
            $practice->update([
                'deleted' => 1
            ]);
        }
        $directory->update([
            'deleted' => 1
        ]);

        return response('delete success', 200);
    }

    public function deleteGuide(Request $request)
    {
        $guide = Guide::find($request->id_guide);

        $taxonomies = Taxonomy::where('id_guide', $guide->id_guide)->get();
        foreach($taxonomies as $taxonomy)
        {
            $taxonomy->update([
                'deleted' => 1
            ]);
        }

        $tasks = Task::where('id_guide', $guide->id_guide)->get();
        foreach($tasks as $task)
        {
            $task->update([
                'deleted' => 1
            ]);
        }

        $guide->update([
            'deleted' => 1
        ]);

        return response('delete success', 200);
    }

    public function deleteLocation(Request $request)
    {
        $location = Location::find($request->id_location);

        $taxonomies = Taxonomy::where('id_location', $location->id_location)->get();
        foreach($taxonomies as $taxonomy)
        {
            $taxonomy->update([
                'deleted' => 1
            ]);
        }

        $tasks = Task::where('id_location', $location->id_location)->get();
        foreach($tasks as $task)
        {
            $task->update([
                'deleted' => 1
            ]);
        }

        $location->update([
            'deleted' => 1
        ]);

        return response('delete success', 200);
    }

    public function deletePractice(Request $request)
    {
        $practice = Practice::find($request->id_practice);

        $taxonomies = Taxonomy::where('id_practice', $practice->id_practice)->get();
        foreach($taxonomies as $taxonomy)
        {
            $taxonomy->update([
                'deleted' => 1
            ]);
        }

        $tasks = Task::where('id_practice', $practice->id_practice)->get();
        foreach($tasks as $task)
        {
            $task->update([
                'deleted' => 1
            ]);
        }

        $practice->update([
            'deleted' => 1
        ]);

        return response('delete success', 200);
    }

    public function getCentralPractice(Request $request)
    {
        if(isset($request->id_central_practice))
            $centralPractice = CentralPractice::find($request->id_central_practice);

        return view('partials.central-practice')->with(['centralpractices' => CentralPractice::where('deleted', 0)->get(), 'previous_id_central_practice' => $centralPractice->id_central_practice ?? '']);
    }
}
