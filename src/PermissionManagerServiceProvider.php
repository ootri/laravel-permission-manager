<?php

namespace Ootri\PermissionManager;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class PermissionManagerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Load routes
        //$this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'Ootri\PermissionManager');

        // Register Livewire Components
        Livewire::component('ootri-permission-management', \Ootri\PermissionManager\Livewire\PermissionManagement::class);
        Livewire::component('ootri-user-management', \Ootri\PermissionManager\Livewire\UserManagement::class);
    }
}
