<?php

namespace App\Providers;

use App\Enums\Role;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        app('router')->aliasMiddleware(Role::admin->value, \App\Http\Middleware\AdminMiddleware::class);
    }
}
