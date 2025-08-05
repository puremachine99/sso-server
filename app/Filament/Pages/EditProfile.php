<?php
namespace App\Filament\Pages;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static string $view = 'filament.pages.edit-profile';
    protected static ?int $navigationSort = 11;
    protected static ?string $navigationLabel = 'Account';

    public function form(Form $form): Form
    {
        return $form
            ->model(auth()->user())
            ->schema($this->getFormSchema())
            ->statePath('data'); // opsional
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
                ->dehydrated(false)
                ->validationMessages([
                    'same' => 'Password dan konfirmasi harus sama.',
                    'min' => 'Password minimal 8 karakter.',
                ]),

            Forms\Components\TextInput::make('password_confirmation')
                ->label('Konfirmasi Password')
                ->password()
                ->nullable()
                ->dehydrated(false)
                ->requiredWith('password')
                ->validationMessages([
                    'required_with' => 'Mohon konfirmasi password Anda.',
                ]),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $user = auth()->user();
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
