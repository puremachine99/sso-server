<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use Filament\Actions;
use App\Models\HcpmUser;
use App\Services\HcpmSyncService;
use Filament\Pages\Actions\Action;
use App\Filament\Resources\UserResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    // Tampilkan header action seperti "Create"
    protected function getHeaderActions(): array
    {
        return [
            \Filament\Pages\Actions\CreateAction::make(),
            Action::make('syncHcpm')
                ->label('Sync from HCPM')
                ->icon('heroicon-o-arrow-down-tray')
                ->requiresConfirmation()
                ->modalHeading('Sinkronisasi dari HCPM')
                ->modalSubheading('Apakah Anda yakin ingin melakukan sync semua user dari HCPM ke portal?')
                ->modalButton('Ya, Lanjutkan')
                ->action(function () {
                    $result = (new HcpmSyncService())->syncAll();

                    Notification::make()
                        ->title('Sync Selesai')
                        ->body("{$result['synced']} user baru disalin, {$result['updated']} user diperbarui.")
                        ->success()
                        ->send();
                }),

        ];
    }

    // Aktifkan create (default-nya true, jadi sebenarnya ini opsional)
    protected function canCreate(): bool
    {
        return true;
    }
}
