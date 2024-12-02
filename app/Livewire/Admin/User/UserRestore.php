<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\User;

use App\Models\User;
use App\Traits\Livewire\HasRestore;
use Livewire\Component;

class UserRestore extends Component
{
    use HasRestore;

    protected function model(): string
    {
        return User::class;
    }

    protected function updateList(): string
    {
        return 'user::index';
    }
}
