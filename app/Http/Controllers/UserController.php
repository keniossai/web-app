<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contact;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('system-catalogs.users')->with(['users' => User::where('active', 1)->get()]);
    }

    public function create()
    {
        return view('system-catalogs.user');
    }

    public function read(Request $request)
    {
        $user = User::with('contact')->where('id_user', $request->id)->first();

        return view('system-catalogs.user')->with(['user' => $user]);
    }

    public function edit(Request $request)
    {
        $user = User::with('contact')->where('id_user', $request->id)->first();

        return view('system-catalogs.user')->with(['user' => $user, 'section' => 'edit']);
    }

    public function save(Request $request)
    {
        $validateEmail = User::where(['email' => $request->email, 'active' => 1])->first();
        $request->flash();

        if (isset($validateEmail) && !isset($request->id_user)) {
            Session::flash('message', 'The email is already exists');
            Session::flash('type', 'error');
            Session::flash('title', 'Error');

            return back();
        }

        $user = User::firstOrNew(['id_user' => $request->id_user]);

        if ($user->exists) {
            $user->email = $request->email;
            if ($request->filled('password')) {
                $currentPassword = $user->getOriginal('password');
                $newPassword = $request->password;
                if (!strcmp($currentPassword, $newPassword) == 0) { // verificar si la nueva contraseña es diferente a la actual
                    $user->password = Hash::make($newPassword);
                }
            }
            $user->timezone = $request->timezone;
            $user->update();

            $user->contact()->update([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email
            ]);

            // Eliminar los UserRole no deseados
            $userRolesQuery = UserRole::where('id_user', $user->id_user);

            if (isset($request->ids_roles)) {
                $userRolesQuery->whereNotIn('id_role', $request->ids_roles)->delete();
            } else {
                $userRolesQuery->where('id_user', $user->id_user)->delete();
            }

            // Agregar los nuevos UserRole
            if (isset($request->ids_role)) {
                foreach ($request->ids_role as $id_role) {
                    UserRole::updateOrCreate(
                        ['id_user' => $user->id_user, 'id_role' => $id_role]
                    );
                }
            }
        } else {
            $user->email = $request->email;
            $user->password = $request->password ? Hash::make($request->password) : null;
            $user->timezone = $request->timezone;
            $user->save();

            Contact::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'type' => 'employee',
                'email' => $request->email,
                'id_user' => $user->id_user
            ]);
        }

        if (isset($request->ids_role)) {
            foreach ($request->ids_role as $id_role) {
                $userRole = UserRole::firstOrNew([
                    'id_user' => $user->id_user,
                    'id_role' => $id_role,
                ]);
                $userRole->save();
            }
        }

        return redirect()->route('read-user', ['id' => $user->id_user]);
    }

    public function deactivate(Request $request)
    {
        $user = User::find($request->id);
        $user->update([
            'active' => 0
        ]);

        $response['logout'] = false;
        if ($request->id == Auth::user()->id_user) {
            $checkId = Auth::user()->provider_id;
            Auth::guard()->logout();
            $request->session()->flush();

            $response['logout'] = true;
            if (isset($checkId)) {
                $azureLogoutUrl = Socialite::driver('azure')->getLogoutUrl(route('login'));
                $response['route'] = $azureLogoutUrl;
            } else {
                $response['route'] = env('APP_URL');
            }
        }

        return response($response);
    }

    public function timeZoneRegister(Request $request)
    {
        User::find(Auth::user()->id_user)->update([
            'timezone' => $request->timezone
        ]);

        $contact = Contact::where('id_user', Auth::user()->id_user)->first();
        $contact->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'job_title' => $request->job_title,
        ]);

        return redirect('/home');
    }

    public function myProfile(Request $request)
    {
        $user = User::find($request->id);
        $qtyClients = Client::where(['owner' => $user->id_user, 'deleted' => 0])->count();
        $qtyProjects = Project::where(['owner' => $user->id_user, 'deleted' => 0])->count();

        return view('admin.profile.profile')->with([
            'user' => $user,
            'qtyClients' => $qtyClients,
            'qtyProjects' => $qtyProjects,
            'view' => $request->view
        ]);
    }

    /**
     * Updates user profile
     */
    public function updateProfile(Request $request)
    {
        $user = User::find($request->id_user);
        $user->update([
            'timezone' => $request->timezone
        ]);
        $user->contact->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'description' => $request->description
        ]);

        if ($request->hasFile('profile_pic')) {
            $path = public_path('files/user/');
            $avatar = $request->file('profile_pic');
            $filename =  'pic_' . time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path . $filename);

            $user->contact->update([
                'profile_pic' => $filename
            ]);
        } else {
            //Delete previous file when nothing is posted

        }

        Session::flash('message', 'Data updated successfully');
        Session::flash('type', 'success');
        Session::flash('title', 'Success');

        return redirect()->route('my-profile', ['id' => $user->id_user]);
    }

    public function deleteUserPicture(Request $request)
    {
        $user = User::find($request->id_user);
        $contact = $user->contact;
        $response['status'] = 0;

        if (isset($contact->profile_pic) && file_exists(public_path() . '/files/user/' . $contact->profile_pic)) {
            unlink('files/user/' . $contact->profile_pic);

            $contact->update([
                'profile_pic' => null
            ]);
            $response['status'] = 1;
        }

        return response($response);
    }
}
