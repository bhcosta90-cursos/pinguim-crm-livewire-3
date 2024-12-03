<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->is(auth()->user());
    }

    public function create(User $user): bool
    {
        return $user->is(auth()->user());
    }

    public function delete(User $user): bool
    {
        return $user->is(auth()->user());
    }

    public function restore(User $user): bool
    {
        return $user->is(auth()->user());
    }

    public function edit(User $user): bool
    {
        return $user->is(auth()->user());
    }
}
