<?php

declare(strict_types = 1);

namespace App\Livewire\Auth\Password;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\{Layout, Rule};
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Recovery extends Component
{
    public ?string $message = null;

    #[Rule(['required', 'email'])]
    public ?string $email = null;

    public function render(): View
    {
        return view('livewire.auth.password.recovery')->layoutData([
            'title' => __('Forgot Your Password?'),
        ]);
    }

    public function submit(): void
    {
        $this->validate();

        Password::sendResetLink($this->only('email'));

        $this->message = __('You will receive an email with the password recovery link.');
        $this->reset('email');
    }
}
