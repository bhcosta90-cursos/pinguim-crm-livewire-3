<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class UserImpersonate extends Component
{
    public function render(): string
    {
        return "<div></div>";
    }

    #[On('user::impersonate')]
    public function execute(User $user): void
    {
        $this->authorize('impersonate', $user);
        session()->put('impersonate', $user->id);
        session()->put('impersonator', auth()->user()->id);
        $this->redirectRoute('dashboard');
    }
}
