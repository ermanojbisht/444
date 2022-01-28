<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Support\Facades\Gate;
use Log;
use Auth;
class AuthGates
{
    public function handle($request, Closure $next)
    {
        if(Auth::guard('web')->check()){
        $user = \Auth::user();
        //Log::info("user = ".print_r($user,true));

        if ($user) {
            $roles            = Role::with('permissions')->get();
            //Log::info("roles = ".print_r($roles,true));
            $permissionsArray = [];

            foreach ($roles as $role) {
                foreach ($role->permissions as $permissions) {
                    $permissionsArray[$permissions->name][] = $role->id;
                }
            }
            //Log::info("permissionsArray = ".print_r($permissionsArray,true));
            //Log::info("permissions = ".print_r($user->permissions()->get(),true));
            foreach ($permissionsArray as $name => $roles) {
                //Log::info("name = ".print_r($name,true));
                //Log::info("roles = ".print_r($roles,true));
                if($user->permissions->where('name',$name)->count()){
                //Log::info("name permit..=======. = ".print_r($name,true));
                    Gate::define($name, function(){
                        return true;
                    });
                }else{
                     //Log::info("name permit nooooooooooooo... = ".print_r($name,true));
                     Gate::define($name, function ($user) use ($roles) {
                        return count(array_intersect($user->roles->pluck('id')->toArray(), $roles)) > 0;
                    });
                 }
            }
            //Log::info("permissionsArray = ".print_r($permissionsArray,true));
        }
    }

        return $next($request);
    }
}

