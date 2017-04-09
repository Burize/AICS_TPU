<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Auth;
class ManagerAuth
{
   
    public function handle($request, Closure $next, $guard = null)
    {
        $auth = Auth::guard($guard);
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }
        if ( $auth->user()->user_type !='manager' && $auth->user()->user_type !='admin' ){
           // return response(,401);
           abort(401);
        }

        return $next($request);
    }
}