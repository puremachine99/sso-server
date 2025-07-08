<?php

namespace App\Filament\Resources\ClientAppResource\Pages;

use App\Filament\Resources\ClientAppResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClientApp extends EditRecord
{
    protected static string $resource = ClientAppResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Pastikan redirect_uris dikonversi ke array jika string
        if (isset($data['redirect_uris']) && is_string($data['redirect_uris'])) {
            $data['redirect_uris'] = array_map('trim', explode(',', $data['redirect_uris']));
        }

        // Hindari perubahan secret
        unset($data['secret']);

        return $data;
    }

}
