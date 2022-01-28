<?php

namespace App\Providers;

use App\Events\AlertCreatedOrModifiedEvent;
use App\Events\UserCreatedEvent;
use App\Listeners\SunInformUserMailTel;
use App\Listeners\SunWelcomeUserMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [SendEmailVerificationNotification::class,],
        UserCreatedEvent::class => [SunWelcomeUserMail::class,],
        AlertCreatedOrModifiedEvent::class => [SunInformUserMailTel::class,],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
