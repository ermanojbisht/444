<?php

namespace App\Providers;

use App\Models\User;
use App\Services\Sms\LocalSmsService;
use App\Services\Sms\SmsInterface;
use App\Services\Sms\SmsService;
use Illuminate\Support\ServiceProvider;

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
    }
}
