<?php

declare(strict_types = 1);

namespace App\Livewire\Auth;

use App\Notifications\ValidationCodeNotification;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class ValidationEmail extends Component
{
    public ?string $code = null;

    public ?string $sendNewCodeMessage = null;

    public function render(): View
    {
        return view('livewire.auth.validation-email')->layoutData(['title' => 'Verify Email Address']);
    }

    public function sendNewCode(): void
    {
        $this->reset('sendNewCodeMessage');

        $user = auth()->user();

        $user->validation_code = $code = random_int(100000, 999999);
        $user->validation_at   = now()->addHour();
        $user->save();

        $user->notify(new ValidationCodeNotification((string) $code));

        $this->sendNewCodeMessage = __('Code was sent to you. Check your mailbox.');
    }

    public function submit(): void
    {
        $this->reset('sendNewCodeMessage');

        $this->validate([
            'code' => function (string $attribute, mixed $value, \Closure $fail) {
                if (now()->greaterThanOrEqualTo(auth()->user()->validation_at)) {
                    $fail(__('Code expired'));
                }

                if (!\Hash::check($value, auth()->user()->validation_code)) {
                    $fail(__('Invalid code'));
                }
            },
        ]);

        $user = auth()->user();

        $user->validation_code   = null;
        $user->validation_at     = null;
        $user->email_verified_at = now();
        $user->save();

        $this->redirectRoute('dashboard');
    }
}
