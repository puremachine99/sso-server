<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Laravel\Passport\Client;

class ClientAppList extends Widget
{
    protected static string $view = 'filament.widgets.client-app-list';
    protected int|string|array $columnSpan = 'full';

    public function getApps()
    {
        return Client::where('revoked', false)->get();
    }
}
