<?php

declare(strict_types = 1);

namespace App\Providers;

use App\Actions\Admin\Layout\VerifyMenuAction;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(VerifyMenuAction::class, function () {
            return new VerifyMenuAction(auth()->user(), Route::currentRouteName());
        });

        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    public function boot(): void
    {
        //
    }
}
