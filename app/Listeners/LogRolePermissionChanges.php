<?php

namespace App\Listeners;

use App\Support\ActivityLogger;
use Illuminate\Contracts\Auth\Authenticatable;
use Spatie\Permission\Events\RoleAttached;
use Spatie\Permission\Events\RoleDetached;
use Spatie\Permission\Events\PermissionAttached;
use Spatie\Permission\Events\PermissionDetached;

class LogRolePermissionChanges
{
    protected function actor(): ?Authenticatable
    {
        return auth()->user();
    }

    public function handleRoleAttached(RoleAttached $event): void
    {
        ActivityLogger::log(
            'role.attached',
            'Role attached to model',
            $event->model,
            ['roles' => $event->rolesOrIds ?? null],
            $this->actor(),
        );
    }

    public function handleRoleDetached(RoleDetached $event): void
    {
        ActivityLogger::log(
            'role.detached',
            'Role detached from model',
            $event->model,
            ['roles' => $event->rolesOrIds ?? null],
            $this->actor(),
        );
    }

    public function handlePermissionAttached(PermissionAttached $event): void
    {
        ActivityLogger::log(
            'permission.attached',
            'Permission attached to model',
            $event->model,
            ['permissions' => $event->permissionsOrIds ?? null],
            $this->actor(),
        );
    }

    public function handlePermissionDetached(PermissionDetached $event): void
    {
        ActivityLogger::log(
            'permission.detached',
            'Permission detached from model',
            $event->model,
            ['permissions' => $event->permissionsOrIds ?? null],
            $this->actor(),
        );
    }
}

