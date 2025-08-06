<?php

namespace App\Livewire;

use Livewire\Component;

class MyCustomProfileComponent extends Component
{
    public function render()
    {
        return view('livewire.my-custom-profile-component', [
            'user' => auth()->user(),
        ]);
    }
}
