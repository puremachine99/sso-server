<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    // Tampilkan header action seperti "Create"
    protected function getHeaderActions(): array
    {
        return [
            \Filament\Pages\Actions\CreateAction::make(),
        ];
    }

    // Aktifkan create (default-nya true, jadi sebenarnya ini opsional)
    protected function canCreate(): bool
    {
        return true;
    }
}
