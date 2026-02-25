<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Регистрируем namespace "admin"
        $this->loadViewsFrom(resource_path('views/admin'), 'admin');
    }
}
