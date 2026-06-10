<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\View\Composers\AdminLayoutComposer;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    // Register the AdminLayoutComposer to be used with the 'layouts.admin' view, allowing it to inject necessary data into that view.
    public function boot(): void
    {
        //
        View::composer('layouts.admin', AdminLayoutComposer::class);
    }
}
