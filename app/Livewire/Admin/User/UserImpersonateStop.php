<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\User;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use OwenIt\Auditing\Events\AuditCustom;

class UserImpersonateStop extends Component
{
    public function render(): View
    {
        return view('livewire.admin.user.user-impersonate-stop');
    }

    #[On('user::impersonate')]
    public function execute(): void
    {
        $userLogged                 = User::find(session()->get('impersonator'));
        $userLogged->auditEvent     = 'impersonate.stop';
        $userLogged->isCustomEvent  = 'impersonate.stop';
        $userLogged->auditCustomNew = [
            'userImpersonate' => session()->get('impersonate'),
        ];

        \Event::dispatch(AuditCustom::class, [$userLogged]);

        session()->forget('impersonate');
        session()->forget('impersonator');

        $this->redirectRoute('admin.user.index');
    }
}
