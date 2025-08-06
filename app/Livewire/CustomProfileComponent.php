<?php

namespace App\Livewire;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextEntry;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
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
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'role' => Auth::user()->role?->name, // jika ada relasi role
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Akun')
                    ->aside()
                    ->description('Berikut detail akun Anda.')
                    ->schema([
                        TextEntry::make('name')->label('Nama Lengkap'),
                        TextEntry::make('email')->label('Email'),
                        TextEntry::make('role')->label('Peran')->default('Manual'), // fallback jika null
                    ]),
            ])
            ->statePath('data');
    }

    public function render(): View
    {
        return view('livewire.custom-profile-component');
    }
}
