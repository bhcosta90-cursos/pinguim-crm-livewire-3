<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Customer;

use App\Models\Customer;
use App\Traits\Livewire\HasDelete;
use Livewire\Component;

class CustomerDelete extends Component
{
    use HasDelete;

    protected function model(): string
    {
        return Customer::class;
    }

    protected function updateList(): string
    {
        return 'customer::index';
    }
}
