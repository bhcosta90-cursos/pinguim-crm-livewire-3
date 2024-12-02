<?php

declare(strict_types = 1);

namespace App\Livewire\Auth;

use App\Actions\Auth\{CodeValidatedAction, ValidationCodeAction, ValidationEmailAction};
use App\Exceptions\UserCodeException;
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

    public function sendNewCode(ValidationEmailAction $validationEmailAction): void
    {
        $this->reset('sendNewCodeMessage');

        $validationEmailAction->handle(auth()->user());

        $this->sendNewCodeMessage = __('Code was sent to you. Check your mailbox.');
    }

    public function submit(
        ValidationCodeAction $validationCodeAction,
        CodeValidatedAction $codeValidatedAction,
    ): void {
        $this->reset('sendNewCodeMessage');

        $this->validate([
            'code' => function (string $attribute, mixed $value, \Closure $fail) use ($validationCodeAction) {
                try {
                    $validationCodeAction->handle(auth()->user(), $value);
                } catch (UserCodeException $exception) {
                    $fail($exception->getMessage());
                }
            },
        ]);

        $user = auth()->user();

        $codeValidatedAction->handle($user);
        $user->save();

        $this->redirectRoute('dashboard');
    }
}
