<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';
    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->mapApiRoutes();
            $this->mapWebRoutes();
            $this->mapWorkDocRoutes();
            $this->mapGrievanceRoutes();
            $this->mapAcrRoutes();
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for ('api', function (Request $request) {
            return Limit::perMinute(1000)->by(optional($request->user())->id ?: $request->ip());
        });
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

    protected function mapWorkDocRoutes()
    {
        Route::middleware('web') // specify here your middlewares
            ->namespace($this->namespace) // leave it as is
        /**
         * the name of your route goes here:
         */
            ->group(base_path('routes/web_docs.php'));
    }

    protected function mapGrievanceRoutes()
    {
        Route::prefix('employee/issue') // if you need to specify a route prefix
            ->middleware('web') // specify here your middlewares
            ->namespace($this->namespace.'\Employee') // leave it as is
        /**
         * the name of your route goes here:
         */
            ->group(base_path('routes/web_grievance.php'));
    }

    protected function mapAcrRoutes()
    {
        Route::prefix('acr') // if you need to specify a route prefix
            ->middleware('web') // specify here your middlewares
            ->namespace($this->namespace.'\Employee') // leave it as is
        /**
         * the name of your route goes here:
         */
            ->group(base_path('routes/web_acr.php'));
    }
}
