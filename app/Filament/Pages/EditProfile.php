<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms;
use Filament\Notifications\Notification;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static string $view = 'filament.pages.edit-profile';
    protected static ?int $navigationSort = 11;
    protected static ?string $navigationLabel = 'Account';

    public function mount(): void
    {
        $this->form->fill([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Nama')
                ->required(),

            Forms\Components\TextInput::make('email')
                ->label('Email')
                ->required()
                ->email(),

            Forms\Components\TextInput::make('password')
                ->label('Password Baru')
                ->password()
                ->nullable()
                ->minLength(8)
                ->same('password_confirmation')
                ->validationMessages([
                    'same' => 'Password dan konfirmasi harus sama.',
                    'min' => 'Password minimal 8 karakter.',
                ]),

            Forms\Components\TextInput::make('password_confirmation')
                ->label('Konfirmasi Password')
                ->password()
                ->nullable()
                ->requiredWith('password')
                ->validationMessages([
                    'required_with' => 'Mohon konfirmasi password Anda.',
                ]),
        ];
    }


    public function save()
    {
        $data = $this->form->getState();

        // Validasi manual jika password diisi [PORTL-41]
        if (!empty($data['password']) && $data['password'] !== $data['password_confirmation']) {
            Notification::make()
                ->title('Password dan konfirmasi tidak cocok.')
                ->danger()
                ->send();

            return; // stop proses simpan
        }

        $user = Auth::user();
        $user->name = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        Notification::make()
            ->title('Profil berhasil diperbarui')
            ->success()
            ->send();
    }

}
