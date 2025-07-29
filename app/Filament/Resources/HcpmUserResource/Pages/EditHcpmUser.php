<?php

namespace App\Filament\Resources\HcpmUserResource\Pages;

use App\Filament\Resources\HcpmUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHcpmUser extends EditRecord
{
    protected static string $resource = HcpmUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
