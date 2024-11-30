<?php

declare(strict_types = 1);

namespace App\Livewire\Auth\Password;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Reset extends Component
{
    public function render(): View
    {
        return view('livewire.auth.password.reset');
    }
}
