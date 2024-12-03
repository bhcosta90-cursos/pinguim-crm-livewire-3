<?php

declare(strict_types = 1);

use App\Livewire\Admin\Customer\CustomerRestore;
use App\Models\{Customer, User};

use function Pest\Laravel\{actingAs, assertNotSoftDeleted};
use function Pest\Livewire\livewire;

it('should soft delete an customer', function () {
    actingAs(User::factory()->create());

    $customer = Customer::factory()->deleted()->create();

    livewire(CustomerRestore::class)
        ->call('confirm', $customer->id)
        ->call('execute');

    assertNotSoftDeleted($customer);
});
