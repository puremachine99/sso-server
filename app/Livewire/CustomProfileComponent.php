<?php

namespace App\Livewire;

use Filament\Forms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\ViewField;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CustomProfileComponent extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public function getSort()
    {
        return null;
    }
    public function mount(): void
    {
        $user = Auth::user();

        $this->data = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => optional($user->role)->name ?? 'Manual',
        ];

        $this->form->fill($this->data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Profil Pengguna')
                    ->schema([
                        ViewField::make('name')
                            ->view('components.display-field')
                            ->viewData(fn() => [
                                'label' => 'Nama Lengkap',
                                'value' => $this->data['name'] ?? null,
                            ]),


                        ViewField::make('email')
                            ->view('components.display-field')
                            ->viewData(['label' => 'Email']),

                        ViewField::make('role')
                            ->view('components.display-field')
                            ->viewData(['label' => 'Peran']),
                    ]),
            ])
            ->statePath('data');
    }

    public function render()
    {
        return view('livewire.custom-profile-component');
    }
}
