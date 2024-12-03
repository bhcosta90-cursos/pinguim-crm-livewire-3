<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Customer;

use App\Models\Customer;
use App\Traits\Livewire\HasRestore;
use Livewire\Component;

class CustomerRestore extends Component
{
    use HasRestore;

    protected function model(): string
    {
        return Customer::class;
    }

    protected function updateList(): string
    {
        return 'customer::index';
    }
}
