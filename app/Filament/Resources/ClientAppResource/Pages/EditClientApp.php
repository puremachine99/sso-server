<?php

namespace App\Filament\Resources\ClientAppResource\Pages;

use App\Filament\Resources\ClientAppResource;
use Filament\Resources\Pages\EditRecord;

class EditClientApp extends EditRecord
{
    protected static string $resource = ClientAppResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['redirect_uris']) && is_string($data['redirect_uris'])) {
            $data['redirect_uris'] = array_map('trim', explode(',', $data['redirect_uris']));
        }

        unset($data['secret']);
        unset($data['icon_path']); // ← jangan simpan icon_path ke oauth_clients

        return $data;
    }
}
