<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Base path project
$basePath = dirname(__DIR__);

// Jika bootstrap/cache tidak ada atau tidak writable, arahkan semua cache ke /tmp
$bootstrapCache = $basePath . '/bootstrap/cache';
if (!is_dir($bootstrapCache) || !is_writable($bootstrapCache)) {
    $tmp = sys_get_temp_dir(); // biasanya /tmp di Linux/container

    // Set ENV runtime agar dipakai Laravel untuk file cache
    $_SERVER['APP_CONFIG_CACHE']    = $_ENV['APP_CONFIG_CACHE']    = $tmp . '/config.php';
    $_SERVER['APP_EVENTS_CACHE']    = $_ENV['APP_EVENTS_CACHE']    = $tmp . '/events.php';
    $_SERVER['APP_PACKAGES_CACHE']  = $_ENV['APP_PACKAGES_CACHE']  = $tmp . '/packages.php';
    $_SERVER['APP_ROUTES_CACHE']    = $_ENV['APP_ROUTES_CACHE']    = $tmp . '/routes.php';
    $_SERVER['APP_SERVICES_CACHE']  = $_ENV['APP_SERVICES_CACHE']  = $tmp . '/services.php';
    $_SERVER['VIEW_COMPILED_PATH']  = $_ENV['VIEW_COMPILED_PATH']  = $tmp . '/views';

    // Jangan tulis log ke file, kirim ke stderr (aman di container)
    $_SERVER['LOG_CHANNEL'] = $_ENV['LOG_CHANNEL'] = $_ENV['LOG_CHANNEL'] ?? 'stderr';
}

return Application::configure(basePath: $basePath)
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // trust proxy (kalau di balik LB/ingress)
        $middleware->trustProxies(at: '*');

        // kalau guest diarahkan ke login custom
        $middleware->redirectGuestsTo(fn () => route('admin.login'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
