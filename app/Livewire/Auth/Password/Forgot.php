<?php

declare(strict_types = 1);

namespace App\Livewire\Auth\Password;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Forgot extends Component
{
    public function render(): View
    {
        return view('livewire.auth.password.forgot');
    }
}
