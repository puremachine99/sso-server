<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class MyCustomProfileComponent extends Page
{
    protected static ?string $navigationIcon = null;
    protected static string $view = 'livewire.my-custom-profile-component';


    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getSort(): ?int
    {
        return null; // Prevent error from Filament expecting this
    }
}
