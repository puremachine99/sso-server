<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ProfileWrapperPage extends Page
{
    protected static ?string $navigationIcon = null;
    protected static string $view = 'filament.pages.profile-wrapper-page';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getSort(): ?int
    {
        return null;
    }
}
