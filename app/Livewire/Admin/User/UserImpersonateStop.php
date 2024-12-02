<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\User;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class UserImpersonateStop extends Component
{
    public function render(): View
    {
        return view('livewire.admin.user.user-impersonate-stop');
    }

    #[On('user::impersonate')]
    public function execute(): void
    {
        session()->forget('impersonate');
        session()->forget('impersonator');
        $this->redirectRoute('admin.user.index');
    }
}
