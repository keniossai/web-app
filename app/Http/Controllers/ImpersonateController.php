<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ImpersonateController extends Controller
{
    public function impersonate(Request $request)
    {
        $userToImpersonate = User::find($request->id);

        $userToImpersonate->update([
            'impersonated_by' => auth()->user()->id_user
        ]);

        $request->session()->put('impersonated_by', $request->id);

        return redirect('/');
    }

    public function leave(Request $request)
    {
        $userToImpersonate = User::find($request->id);

        $userToImpersonate->update([
            'impersonated_by' => null
        ]);

        $request->session()->forget('impersonated_by');

        return redirect('/');
    }
}
