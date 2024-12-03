<?php

declare(strict_types = 1);

namespace App\Livewire\Auth\Password;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Attributes\{Computed, Layout, Rule};
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Reset extends Component
{
    public ?string $token = null;

    #[Rule(['required', 'email', 'confirmed'])]
    public ?string $email = null;

    public ?string $email_confirmation = null;

    #[Rule(['required', 'confirmed'])]
    public ?string $password = null;

    public ?string $password_confirmation = null;

    public function mount(?string $token = null, ?string $email = null): void
    {
        $this->token = request('token', $token);
        $this->email = request('email', $email);

        if ($this->tokenNotValid()) {

            session()->flash('status', 'Token Invalid');

            $this->redirectRoute('login');
        }
    }

    public function render(): View
    {
        return view('livewire.auth.password.reset')->layoutData([
            'title' => __('Reset Password'),
        ]);
    }

    #[Computed]
    public function obfuscatedEmail(): string
    {
        return obfuscate_email($this->email);
    }

    public function submit(): void
    {
        $this->validate();

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, $password) {
                $user->password       = $password;
                $user->remember_token = Str::random(60);
                $user->save();

                event(new PasswordReset($user));
            }
        );

        session()->flash('status', __($status));

        if ($status !== Password::PASSWORD_RESET) {
            return;
        }

        $this->redirect(route('login'));
    }

    protected function tokenNotValid(): bool
    {
        $tokens = \DB::table('password_reset_tokens')
            ->get(['token']);

        foreach ($tokens as $t) {
            if (\Hash::check($this->token, $t->token)) {
                return false;
            }
        }

        return true;
    }
}
