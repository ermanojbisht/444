<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
        $this->mapWorkDocRoutes();
        $this->mapInstanceRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     * These routes are typically stateless.
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    /**
     * Define the User routes of the application.
     *
     *
     * @return void
     */
    protected function mapWorkDocRoutes()
    {
        Route::middleware('web') // specify here your middlewares
            ->namespace($this->namespace) // leave it as is
            /** the name of your route goes here: */
            ->group(base_path('routes/web_docs.php'));
    }





    protected function mapInstanceRoutes()
    {
        Route::prefix('track')  // if you need to specify a route prefix
             ->middleware('web') // specify here your middlewares
            //->namespace($this->namespace.'\Track') // leave it as is
            /** the name of your route goes here: */
            ->group(base_path('routes/web_instance.php'));
    }

}
