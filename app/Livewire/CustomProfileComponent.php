<?php

namespace App\Livewire;

use Filament\Forms;
use Livewire\Component;
use Filament\Forms\Form;
use Forms\Components\TextEntry;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Joaopaulolndev\FilamentEditProfile\Concerns\HasSort;

class CustomProfileComponent extends Component implements HasForms
{
    use InteractsWithForms;
    use HasSort;

    public ?array $data = [];

    protected static int $sort = 0;

    public function mount(): void
    {
        $user = Auth::user();
        $this->data = [
            'name' => $user->name,
            'email' => $user->email,
            'joined_at' => $user->created_at->format('Y‑m‑d'),
            // tambahkan custom field profil kalau perlu
            'bio' => $user->bio ?? '—',
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Profil Saya')
                    ->schema([
                        TextEntry::make('name')->label('Nama'),
                        TextEntry::make('email')->label('Email'),
                        TextEntry::make('joined_at')->label('Tanggal Bergabung'),
                        TextEntry::make('bio')->label('Bio'),
                    ])
            ])
            ->statePath('data');
    }


    public function save(): void
    {
        $data = $this->form->getState();
    }

    public function render(): View
    {
        return view('livewire.custom-profile-component');
    }
}
