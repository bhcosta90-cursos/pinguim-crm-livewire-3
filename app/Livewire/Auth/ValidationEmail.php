<?php

declare(strict_types = 1);

namespace App\Livewire\Auth;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class ValidationEmail extends Component
{
    public function render(): View
    {
        return view('livewire.auth.validation-email')->layoutData(['title' => 'Verify Email Address']);
    }
}
