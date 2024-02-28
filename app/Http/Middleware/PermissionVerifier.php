<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PermissionVerifier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $isAllowed = false;
        foreach(Auth::user()->userRole as $item) {
            if($item->role->is_allowed($request->route()->getName())) {
                 $isAllowed = true;
            }
        }

        if($isAllowed) {
            return $next($request);
        } else {
            Session::flash('message', 'You are not allowed to do that');
            Session::flash('title', 'Forbidden');
            Session::flash('type', 'error');
            return back();
        }
    }
}
