<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use Filament\Actions;
use App\Models\HcpmUser;
use Filament\Actions\Action;
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
                ->color('secondary')
                ->requiresConfirmation()
                ->modalHeading('Sinkronisasi dari HCPM')
                ->modalSubheading('Apakah Anda yakin ingin melakukan sync semua user dari HCPM ke portal?')
                ->modalButton('Ya, Lanjutkan')
                ->action(function () {
                    $synced = 0;
                    $skipped = 0;

                    $hcpmUsers = HcpmUser::all();

                    foreach ($hcpmUsers as $hcpm) {
                        $user = User::where('email', $hcpm->email)->first();

                        if (!$user) {
                            $user = User::create([
                                'name' => $hcpm->name,
                                'email' => $hcpm->email,
                                'username' => $hcpm->username ?? null,
                                'department_id' => $hcpm->department_id ?? null,
                                'password' => bcrypt('12345678'),
                                'source' => 'synced user',
                            ]);

                            $role = $user->email === 'puremachine99@gmail.com'
                                ? 'super_admin'
                                : 'smartnakama';

                            $user->syncRoles([$role]);
                            $synced++;
                        } else {
                            $skipped++;
                        }
                    }

                    Notification::make()
                        ->title('Sync Selesai')
                        ->body("Berhasil sync {$synced} user baru. {$skipped} dilewati.")
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
