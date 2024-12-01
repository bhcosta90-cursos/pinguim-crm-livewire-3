<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\User;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class UserCreate extends Component
{
    public function render(): View
    {
        return view('livewire.admin.user.user-create');
    }
}
