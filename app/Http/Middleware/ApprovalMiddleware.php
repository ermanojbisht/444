<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Support\Facades\Gate;
use Auth;

class ApprovalMiddleware
{
    public function handle($request, Closure $next)
    {
        if(Auth::guard('web')->check()){
        if (auth()->check()) {
            if (!auth()->user()->approved) {
                auth()->logout();

                return redirect()->route('login')->with('message', trans('global.yourAccountNeedsAdminApproval'));
            }
        }
    }

        return $next($request);
    }
}
