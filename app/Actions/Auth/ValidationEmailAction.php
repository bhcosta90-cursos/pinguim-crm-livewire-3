<?php

declare(strict_types = 1);

namespace App\Actions\Auth;

use App\Models\User;
use App\Notifications\ValidationCodeNotification;

class ValidationEmailAction
{
    public function handle(User $user): void
    {
        $user->validation_code = $code = (string) random_int(100000, 999999);
        $user->validation_at   = now()->addHour()->format('Y-m-d H:i:s');
        $user->save();

        $user->notify(new ValidationCodeNotification((string) $code));
    }
}
