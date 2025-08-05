<?php
namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class UserWelcomeWidget extends Widget
{
    protected static string $view = 'filament.widgets.user-welcome-widget';

    protected static ?int $sort = -1; // biar tampil paling atas

    protected int|string|array $columnSpan = 'full';

    public function getUser()
    {
        return Auth::user();
    }
}
