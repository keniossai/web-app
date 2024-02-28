<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $checkUser = false;
        foreach(Auth::user()->userRole as $item){
            if($item->role->active == 0 || $item->user->active == 0){
                $checkUser = true;
            }
        }

        if ($checkUser) {
            Auth::guard()->logout();

            Session::flash('message', 'User or user role is deactivated');
            Session::flash('type', 'error');
            Session::flash('title', 'Error');
            return redirect()->back();
        }else{
            $id_role = Role::where(['code' => 'guest', 'active' => 1])->first()->id_role;
            $userAuth = Auth::user();

            if($userAuth->userRole->first() == null){
                return view('custom.welcome-to-guest');
            }

            if($userAuth->userRole->first()->id_role == $id_role)
            {
                if(!isset($userAuth->timezone))//registro de zona
                {
                    return view('custom.time-zone-register');
                } else { //bienvenido para ser asignado un rol
                    return view('custom.welcome-to-guest');
                }
            }

            return view('index');
        }
    }

    public function getUnderConstructionView()
    {
        return view('common.404');
    }

    public function test()
    {
        return view('test');
    }

    public function saveAll(Request $request)
    {
        //no longer used
        $users = collect($request->data)->where('action', '!=', 'none')->all();

        foreach($users as $user){
            $newUser = User::findOrNew($user['id']);
            $newUser->name = $user['name'];
            $newUser->email = $user['email'];
            $newUser->id_role = $user['role'];
            $newUser->timezone = isset($user['timezone']) ? $user['timezone'] : config('app.timezone');

            $newUser->exists ? $newUser->update() : $newUser->save();

        }

        //delete
        if(isset($request->ids_delete)){
            foreach($request->ids_delete as $id){
                $user = User::find($id);
                $user->update([
                    'active' => 0
                ]);
            }
        }

        return response('update success', 200);
    }
}
