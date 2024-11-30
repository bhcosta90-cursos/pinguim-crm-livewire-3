<?php

declare(strict_types = 1);

namespace App\Livewire\Auth\Password;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
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
        return $this->obfuscate_email($this->email);
    }

    public function submit(): void {
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

    protected function obfuscate_email(?string $email = null): string
    {
        if (!$email) {
            return '';
        }

        $split = explode('@', $email);

        if(count($split) !== 2) {
            return '';
        }

        $firstPart       = $split[0];
        $qty             = (int)floor(strlen($firstPart) * 0.75);
        $remaining       = strlen($firstPart) - $qty;
        $maskedFirstPart = substr($firstPart, 0, $remaining) . str_repeat('*', $qty);

        $secondPart       = $split[1];
        $qty              = (int)floor(strlen($secondPart) * 0.75);
        $remaining        = strlen($secondPart) - $qty;
        $maskedSecondPart = str_repeat('*', $qty) . substr($secondPart, $remaining * -1, $remaining);

        return $maskedFirstPart . '@' . $maskedSecondPart;
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
