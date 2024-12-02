<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\User;

use App\Enums\Permission\Can;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{Computed, On};
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class UserEdit extends Component
{
    use Interactions;

    public ?User $user = null;

    public ?string $password = null;

    public bool $slide = false;

    public array $permissions = [];

    public function mount(): void
    {
        $this->authorize('edit', User::class);
    }

    public function render(): View
    {
        return view('livewire.admin.user.user-edit');
    }

    #[On('user::edit')]
    public function loadUser(User $user): void
    {
        $this->user        = $user;
        $this->permissions = $user->permissions()->pluck('name')->toArray();
        $this->password    = null;
        $this->slide       = true;
    }

    public function submit(): void
    {
        $this->authorize('edit', User::class);
        $this->validate();

        \DB::transaction(function () {
            if ($this->password) {
                $this->user->password = $this->password;
            }
            $this->user->save();

            $permissions = collect($this->permissions)
                ->map(fn (string $permission) => Can::from($permission))
                ->toArray();

            $this->user->givePermissionTo($permissions);

            $this->toast()->success(__('Usuário cadastrado com sucesso!'))->send();
            $this->slide = false;
            $this->dispatch('user::index');
        });
    }

    #[Computed]
    public function cans(): array
    {
        return collect(Can::cases())
            ->sortBy(fn ($can) => $can->value)
            ->map(fn ($can) => $can->value)
            ->toArray();
    }

    protected function rules(): array
    {
        return [
            'user.name'   => 'required|string|min:3|max:150',
            'user.email'  => 'required|email:rfc,filter|min:3|max:150',
            'password'    => 'nullable|string|min:8|max:20',
            'permissions' => 'nullable|array',
        ];
    }
}
