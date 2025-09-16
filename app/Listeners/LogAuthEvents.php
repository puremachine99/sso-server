<?php

namespace App\Listeners;

use App\Support\ActivityLogger;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\PasswordReset;

class LogAuthEvents
{
    public function handleLogin(Login $event): void
    {
        ActivityLogger::log(
            'auth.login',
            'User logged in',
            $event->user,
            [
                'guard' => $event->guard,
                'remember' => (bool) $event->remember,
            ],
            $event->user,
        );
    }

    public function handleLogout(Logout $event): void
    {
        ActivityLogger::log(
            'auth.logout',
            'User logged out',
            $event->user,
            [
                'guard' => $event->guard,
            ],
            $event->user,
        );
    }

    public function handleFailed(Failed $event): void
    {
        ActivityLogger::log(
            'auth.login_failed',
            'Failed login attempt',
            null,
            [
                'email' => $event->credentials['email'] ?? null,
                'guard' => $event->guard,
            ],
            null,
        );
    }

    public function handlePasswordReset(PasswordReset $event): void
    {
        ActivityLogger::log(
            'auth.password_reset',
            'Password was reset',
            $event->user,
            [],
            $event->user,
        );
    }
}

