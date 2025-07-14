<?php
namespace App\Listeners;

use Laravel\Passport\Events\AccessTokenCreated;
use Illuminate\Support\Facades\Request;
use App\Models\User;
use App\Models\LoginLog;

class LogPassportLogin
{
    public function handle(AccessTokenCreated $event)
    {
        $user = User::find($event->userId);

        if (!$user)
            return;

        LoginLog::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'app_code' => Request::input('client_id') ?? 'unknown',
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent'),
            'logged_in_at' => now(),
            'login_type' => 'oauth',
        ]);

    }
}
