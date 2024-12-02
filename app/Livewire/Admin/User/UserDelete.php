<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\User;

use App\Models\User;
use App\Traits\Livewire\HasDelete;
use Livewire\Component;

class UserDelete extends Component
{
    use HasDelete;

    protected function model(): string
    {
        return User::class;
    }

    protected function updateList(): string
    {
        return 'user::index';
    }
}
