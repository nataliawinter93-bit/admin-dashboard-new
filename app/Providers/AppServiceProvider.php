<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\View\Components\AdminLayout;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User; 
use App\Observers\ActivityLogObserver;


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
    public function boot(): void
    {
        Blade::component('admin-layout', AdminLayout::class);
        User::observe(ActivityLogObserver::class);
        
    }
}
