<?php

declare(strict_types = 1);

namespace App\Livewire\Profile;

use App\Actions\Auth\{CodeValidatedAction, ValidationCodeAction, ValidationEmailAction};
use App\Exceptions\UserCodeException;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\{Auth, Session};
use Illuminate\Validation\{Rule, ValidationException};
use Livewire\Component;

class UpdateProfileInformationForm extends Component
{
    public function render(): View
    {
        return view('livewire.profile.update-profile-information-form');
    }

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $code = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name  = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name'     => ['required', 'string', 'max:255'],
            'password' => ['required', 'current_password:'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($this->code) {
            $validationCodeAction = app(ValidationCodeAction::class);

            try {
                $validationCodeAction->handle(auth()->user(), $this->code);
                app(CodeValidatedAction::class)->handle($user);
            } catch (UserCodeException $exception) {
                throw ValidationException::withMessages([
                    'code' => $exception->getMessage(),
                ]);
            }
        }

        $user->save();

        $this->reset(['password']);
        $this->dispatch('profile-updated', name: $user->name);
    }

    public function sendVerification(ValidationEmailAction $validationEmailAction): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $validationEmailAction->handle($user);

        Session::flash('status', 'verification-link-sent');
    }
}
