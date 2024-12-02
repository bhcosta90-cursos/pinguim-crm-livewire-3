<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Enums\Permission\Can;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(Can::BeAnAdmin);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(Can::BeAnAdmin);
    }

    public function edit(User $user, User $userActual): bool
    {
        return $user->hasPermissionTo(Can::BeAnAdmin) && $user->id !== $userActual->id;
    }

    public function delete(User $user, User $userDeleted): bool
    {
        return $user->hasPermissionTo(Can::BeAnAdmin) && $user->id !== $userDeleted->id;
    }

    public function restore(User $user): bool
    {
        return $user->hasPermissionTo(Can::BeAnAdmin);
    }

    public function impersonate(User $user, User $userActual): bool
    {
        if ($user->is($userActual) || filled($userActual->deleted_at)) {
            return false;
        }

        return $user->hasPermissionTo(Can::BeAnAdmin)
            && $user->hasPermissionTo(Can::Impersonate);
    }
}
