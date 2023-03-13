<?php

namespace App\Providers;

use App\Models\Agent;
use App\Models\Application;
use App\Models\Provider;
use App\Observers\AgentObserver;
use App\Observers\ApplicationObserver;
use App\Observers\ProviderObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Agent::observe(AgentObserver::class);
        Application::observe(ApplicationObserver::class);
        Provider::observe(ProviderObserver::class);
    }
}
