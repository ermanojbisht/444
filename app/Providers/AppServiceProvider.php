<?php

namespace App\Providers;

use App\Http\Controllers\Auth\VerificationController;
use App\Models\User;
use App\Services\Sms\LocalSmsService;
use App\Services\Sms\SmsInterface;
use App\Services\Sms\SmsService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {//mkb
           // $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
        if ($this->app->isLocal() || (config('services.sms.url')=='none')) {
            $this->app->singleton(SmsInterface::class, function($app) {
                return new LocalSmsService();
            });
        }else{
            $this->app->singleton(SmsInterface::class, function($app) {
                return new SmsService(config('services.sms.url'),config('services.sms.apiKey'),config('services.sms.senderId'));
            });
        }

        $this->app->afterResolving(VerificationController::class, function ($controller) {
            // use the name you set for your rate limiter below mkb:check verification mails
            $controller->middleware('throttle:verification');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         /*\DB::listen(function($query) {
            \Log::info(
                $query->sql,
                $query->bindings,
                $query->time
            );
        });*/
       //User::observe(UserObserver::class);
       // choose the name you want for your rate limiter mkb:check verification mails
        RateLimiter::for('verification', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip());
        });
    }
}
