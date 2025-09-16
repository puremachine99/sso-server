<?php

namespace App\Support;

use App\Models\ActivityLog;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

class ActivityLogger
{
    public static function log(
        string $event,
        ?string $description = null,
        mixed $subject = null,
        array $properties = [],
        ?Authenticatable $causer = null,
        ?Request $request = null,
    ): ActivityLog {
        $request ??= request();
        $causer ??= auth()->user();

        $log = new ActivityLog([
            'event' => $event,
            'description' => $description,
            'method' => optional($request)->method(),
            'url' => optional($request)->fullUrl(),
            'ip' => optional($request)->ip(),
            'user_agent' => optional($request)->header('User-Agent'),
            'properties' => $properties ?: null,
        ]);

        if ($causer) {
            $log->causer()->associate($causer);
        }
        if ($subject) {
            $log->subject()->associate($subject);
        }

        $log->save();
        return $log;
    }
}

