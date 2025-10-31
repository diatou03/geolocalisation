<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Login;
use App\Listeners\StoreUserLoginInfo;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Les événements auxquels votre application doit répondre.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Login::class => [
            StoreUserLoginInfo::class,
        ],
    ];

    /**
     * Enregistrer les événements pour l'application.
     */
    public function boot(): void
    {
        parent::boot();
    }
}
