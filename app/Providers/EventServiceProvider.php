<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Listeners\LogAuthEvents;
use App\Listeners\LogRolePermissionChanges;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // Auth events
        \Illuminate\Auth\Events\Login::class => [
            LogAuthEvents::class.'@handleLogin',
        ],
        \Illuminate\Auth\Events\Logout::class => [
            LogAuthEvents::class.'@handleLogout',
        ],
        \Illuminate\Auth\Events\Failed::class => [
            LogAuthEvents::class.'@handleFailed',
        ],
        \Illuminate\Auth\Events\PasswordReset::class => [
            LogAuthEvents::class.'@handlePasswordReset',
        ],

        // Spatie Permission events
        \Spatie\Permission\Events\RoleAttached::class => [
            LogRolePermissionChanges::class.'@handleRoleAttached',
        ],
        \Spatie\Permission\Events\RoleDetached::class => [
            LogRolePermissionChanges::class.'@handleRoleDetached',
        ],
        \Spatie\Permission\Events\PermissionAttached::class => [
            LogRolePermissionChanges::class.'@handlePermissionAttached',
        ],
        \Spatie\Permission\Events\PermissionDetached::class => [
            LogRolePermissionChanges::class.'@handlePermissionDetached',
        ],
    ];

    public function boot(): void
    {
        parent::boot();
    }
}
