<?php

declare(strict_types = 1);

use App\Livewire\Admin\Customer\CustomerDelete;
use App\Models\{Customer, User};

use function Pest\Laravel\{actingAs, assertSoftDeleted};
use function Pest\Livewire\livewire;

it('should soft delete an customer', function () {
    actingAs(User::factory()->create());

    $customer = Customer::factory()->create();

    livewire(CustomerDelete::class)
        ->call('confirm', $customer->id)
        ->call('execute');

    assertSoftDeleted($customer);
});
