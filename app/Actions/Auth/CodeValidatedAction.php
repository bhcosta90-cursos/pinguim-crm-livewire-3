<?php

declare(strict_types = 1);

namespace App\Actions\Auth;

use App\Models\User;

class CodeValidatedAction
{
    public function handle(User $user): void
    {
        $user->validation_code   = null;
        $user->validation_at     = null;
        $user->email_verified_at = now()->format('Y-m-d H:i:s');
    }
}
