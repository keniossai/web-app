<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirecToProvider()
    {
        return Socialite::driver('azure')->redirect();
    }

    public function handleProviderCallback()
    {
        $azureUser = Socialite::driver('azure')->stateless()->user();

        $userCheck = User::where(['email' =>  $azureUser->user['mail']])->first(); //'provider_id' => $azureUser->getId(),
        if(!$userCheck){
            $user = User::firstOrCreate([
                'provider_id' => $azureUser->getId(),
                'email' => $azureUser->user['mail']
            ]);

            Contact::firstOrCreate([
                'id_user' => $user->id_user,
                'name' => $azureUser->user['displayName'],
                'last_name' => $azureUser->user['givenName'],
                'phone' => $azureUser->user['mobilePhone'],
                'type' => 'employee',
                'email' => $azureUser->user['mail'],
                'job_title' => $azureUser->user['jobTitle'],
            ]);

            UserRole::firstOrCreate([
                'id_user' => $user->id_user,
                'id_role' => Role::where(['code' => 'guest', 'active' => 1])->first()->id_role,
            ]);

            auth()->login($user, true);
            return redirect('/home');
        }else{
            $checkUser = false;

            foreach($userCheck->userRole as $item){
                if($item->role->active == 0 || $item->user->active == 0){
                    $checkUser = true;
                }
            }

            if ($checkUser) {
                Auth::guard()->logout();
                Session::flash('message', 'User or user role is deactivated');
                Session::flash('type', 'error');
                Session::flash('title', 'Error');

                $azureLogoutUrl = Socialite::driver('azure')->getLogoutUrl(route('login'));
                return redirect($azureLogoutUrl);
            }else{
                auth()->login($userCheck, true);
                return redirect('/home');
            }
        }
    }

    public function logout(Request $request)
    {
        $checkId = Auth::user()->provider_id;
        Auth::guard()->logout();
        $request->session()->flush();

        if(isset($checkId)){
            $azureLogoutUrl = Socialite::driver('azure')->getLogoutUrl(route('login'));

            return redirect($azureLogoutUrl);
        } else {
            return redirect('/');
        }
    }
}
