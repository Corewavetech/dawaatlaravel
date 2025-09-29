<?php

namespace Corewave\Subscription\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class SubscriptionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');        

    }

    public function register()
    {
        //
    }    

}
