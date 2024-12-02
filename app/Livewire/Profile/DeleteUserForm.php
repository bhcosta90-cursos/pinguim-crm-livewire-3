<?php

declare(strict_types = 1);

namespace App\Livewire\Profile;

use App\Actions\Auth\LogoutAction;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class DeleteUserForm extends Component
{
    use Interactions;

    public ?User $user = null;

    public ?string $password = null;

    public function render(): View
    {
        return view('livewire.profile.delete-user-form');
    }

    public function confirm(): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        $this->user = auth()->user();

        $this->dialog()
            ->question(__('Atenção!'), __('Você tem certeza?'))
            ->confirm(__('Confirmar'), 'execute')
            ->cancel(__('Cancelar'))
            ->send();
    }

    public function execute(LogoutAction $logout): void
    {
        $this->user->delete();
        $logout->handle();
        $this->redirectRoute('login', navigate: true);
    }
}
