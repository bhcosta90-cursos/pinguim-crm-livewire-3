<?php

declare(strict_types = 1);

namespace App\Livewire\Dev;

use App\Actions\Auth\Logout;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Login extends Component
{
    public ?int $selectedUser = null;

    public function mount(): void
    {
        if (auth()->check()) {
            $this->selectedUser = auth()->user()->id;
        }
    }

    public function render(): View
    {
        return view('livewire.dev.login');
    }

    #[Computed]
    public function options(): array
    {
        return User::query()
            ->orderBy('id')
            ->get()
            ->map(function (User $user): array {
                return [
                    'value' => $user->id,
                    'label' => $user->name,
                ];
            })->toArray();
    }

    public function updatedSelectedUser(Logout $logout): void
    {
        if (blank($this->selectedUser)) {
            $logout->handle();
            $this->redirectRoute('login');
        }

        if (filled($this->selectedUser)) {
            auth()->loginUsingId($this->selectedUser);
            $this->redirectRoute('dashboard');
        }
    }
}
