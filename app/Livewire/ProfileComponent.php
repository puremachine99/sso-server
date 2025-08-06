<?php

namespace App\Livewire;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\ViewField;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class ProfileComponent extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user();

        $this->data = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => optional($user->role)->name ?? '-',
            'tipe_akun' => $user->tipe_akun ?? 'manual',
        ];

        $this->form->fill($this->data);
    }

    public function form(Form $form): Form
    {
        $isManual = $this->data['tipe_akun'] === 'manual';

        return $form
            ->schema([
                Section::make('Profil Pengguna')
                    ->schema([
                        $isManual
                            ? TextInput::make('name')->label('Nama Lengkap')->disabled()
                            : ViewField::make('name')
                                ->label('Nama Lengkap')
                                ->view('components.display-field')
                                ->viewData(['value' => $this->data['name']]),

                        ViewField::make('email')
                            ->label('Email')
                            ->view('components.display-field')
                            ->viewData(['value' => $this->data['email']]),

                        ViewField::make('role')
                            ->label('Peran')
                            ->view('components.display-field')
                            ->viewData(['value' => $this->data['role']]),
                    ])
            ])
            ->statePath('data');
    }

    public function render()
    {
        return view('livewire.profile-component');
    }
}
