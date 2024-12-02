<?php

declare(strict_types = 1);

namespace App\Actions\Auth;

class LogoutAction
{
    public function handle(): void
    {
        auth()->logout();

        session()->invalidate();
        session()->regenerateToken();
    }
}
