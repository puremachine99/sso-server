<?php

namespace App\Livewire;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Joaopaulolndev\FilamentEditProfile\Concerns\HasSort;

class CustomProfileComponent extends Component implements HasForms
{
    use InteractsWithForms;
    use HasSort;

    public ?array $data = [];

    protected static int $sort = 0;

    public function mount(): void
    {
        $this->form->fill([
            'password' => '',
            'password_confirmation' => '',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Ganti Password')
                    ->description('Masukkan password baru jika ingin mengubahnya.')
                    ->schema([
                        TextInput::make('password')
                            ->label('Password Baru')
                            ->password()
                            ->dehydrated(false) // jangan langsung simpan ke model
                            ->minLength(8)
                            ->same('password_confirmation')
                            ->nullable()
                            ->validationMessages([
                                'min' => 'Password minimal 8 karakter.',
                                'same' => 'Konfirmasi password tidak sama.',
                            ]),

                        TextInput::make('password_confirmation')
                            ->label('Konfirmasi Password')
                            ->password()
                            ->dehydrated(false)
                            ->nullable(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $password = $this->form->getState()['password'] ?? null;

        if (!empty($password)) {
            $user = auth()->user();

            // Simpan ke DB portal
            $user->update([
                'password' => Hash::make($password),
            ]);

            // Sinkron ke DB HCPM
            DB::connection('hcpm')->table('users')
                ->where('email', $user->email)
                ->update([
                    'password' => Hash::make($password),
                    'updated_at' => now(),
                ]);
        }
    }

    public function render(): View
    {
        return view('livewire.custom-profile-component');
    }
}
