<?php

namespace App\Http\Middleware;

use App\Support\ActivityLogger;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogHttpActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Hanya catat non-GET untuk mengurangi noise
        if (strtoupper($request->method()) !== 'GET') {
            try {
                $input = collect($request->all())
                    ->except(['password', 'password_confirmation', 'current_password', 'token'])
                    ->toArray();

                $routeName = $request->route()?->getName();

                ActivityLogger::log(
                    'http.request',
                    $routeName ? "HTTP {$request->method()} {$routeName}" : "HTTP {$request->method()}",
                    null,
                    [
                        'route' => $routeName,
                        'status' => $response->getStatusCode(),
                        'input' => $input,
                    ]
                );
            } catch (\Throwable $e) {
                // jangan ganggu response utama
            }
        }

        return $response;
    }
}

