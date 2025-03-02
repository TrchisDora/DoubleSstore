<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\OrderChangedByAdmin::class => [
            \App\Listeners\SendAdminOrderChangeNotification::class,
        ],
    ];
    
}
