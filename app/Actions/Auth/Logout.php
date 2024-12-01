<?php

declare(strict_types = 1);

namespace App\Actions\Auth;

class Logout
{
    public function handle(): void
    {
        auth()->logout();

        session()->invalidate();
        session()->regenerateToken();
    }
}
