<?php

namespace App\Livewire;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Services\DualDatabaseProfileWriter;

class EditProfileForm extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user();

        $this->form->fill([
            'username' => $user->username ?? '',
            'email'    => $user->email,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Profil')
                    ->schema([
                        Forms\Components\TextInput::make('username')
                            ->label('Username')
                            ->maxLength(150)
                            ->required(),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Ubah Kata Sandi')
                    ->schema([
                        Forms\Components\TextInput::make('current_password')
                            ->label('Password Saat Ini')
                            ->password()
                            ->revealable()
                            ->rule('nullable|current_password')
                            ->dehydrated(false),

                        Forms\Components\TextInput::make('password')
                            ->label('Password Baru')
                            ->password()
                            ->revealable()
                            ->rule('nullable')
                            ->rule(
                                PasswordRule::min(8)->mixedCase()->numbers()->symbols()
                            )
                            ->dehydrated(false),

                        Forms\Components\TextInput::make('password_confirmation')
                            ->label('Konfirmasi Password Baru')
                            ->password()
                            ->revealable()
                            ->same('password')
                            ->dehydrated(false),
                    ])
                    ->collapsible(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $user = Auth::user();
        $originalEmail = $user->email;

        if (!empty($state['password'])) {
            $this->validate([
                'data.current_password' => ['required', 'current_password'],
                'data.password' => [
                    'required',
                    PasswordRule::min(8)->mixedCase()->numbers()->symbols(),
                ],
                'data.password_confirmation' => ['required', 'same:data.password'],
            ]);
        }

        $payload = [
            'username' => $state['username'] ?? null,
            'email'    => $state['email'],
            'password' => $state['password'] ?? null,
        ];

        app(DualDatabaseProfileWriter::class)->updateProfile($user, $payload, $originalEmail);

        Notification::make()
            ->title('Profil berhasil diperbarui')
            ->success()
            ->send();

        // kosongkan field password; muat ulang username/email dari state terbaru
        $this->form->fill([
            'username' => $payload['username'],
            'email'    => $payload['email'],
            'current_password' => null,
            'password' => null,
            'password_confirmation' => null,
        ]);
    }

    public function render()
    {
        return view('livewire.edit-profile-form');
    }
    public static function getSort(): int
    {
        // atur urutan tampil dibanding komponen lain (angka kecil = lebih atas)
        return 10;
    }

    public static function getTitle(): string
    {
        // judul seksi yang muncul di halaman Edit Profile
        return 'Profil & Keamanan';
    }

    public static function getIcon(): ?string
    {
        // opsional, untuk konsistensi API plugin (bisa null)
        return 'heroicon-o-user';
    }

}
