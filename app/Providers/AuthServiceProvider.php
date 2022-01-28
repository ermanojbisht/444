<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        //'App\Models\ForestStatus' => 'App\Policies\ForestStatusPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();        
        //mkb this i got from some site 
        /*if (!app()->runningInConsole()) {
            Passport::routes();
        };*/
        //mkb this i got from laravel 7 documentation        
        //Passport::routes();
        //mkb this i got from laravel 8 documentation
         if (! $this->app->routesAreCached()) {
            Passport::routes();
        }
        //Passport::loadKeysFrom(__DIR__.'/../secrets/oauth');  
        //done it thruogh config file
    }
}
