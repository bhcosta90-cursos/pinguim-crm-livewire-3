<?php

declare(strict_types = 1);

namespace App\Actions\Auth;

use App\Exceptions\UserCodeException;
use App\Models\User;

class ValidationCodeAction
{
    public function handle(User $user, string $value): void
    {
        if (now()->greaterThanOrEqualTo($user->validation_at)) {
            throw new UserCodeException(__('Code expired'));
        }

        if (!\Hash::check($value, $user->validation_code)) {
            throw new UserCodeException(__('Invalid code'));
        }
    }
}
