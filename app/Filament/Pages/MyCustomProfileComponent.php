<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;

class MyCustomProfileComponent extends Page
{
    protected static ?string $navigationIcon = null;
    protected static string $view = 'filament.pages.my-custom-profile-component';

    // Optional: supaya tidak muncul di sidebar, cukup dari plugin saja
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
