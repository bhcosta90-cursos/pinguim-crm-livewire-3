<?php

declare(strict_types = 1);

use App\Livewire\Admin\Customer\CustomerIndex;
use App\Models\{Customer, User};
use Illuminate\Contracts\Pagination\Paginator;

use function Pest\Laravel\{actingAs, get};
use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->user = User::factory()
        ->admin()
        ->create();

    actingAs($this->user);
});

it('should render a component', function () {
    get('/admin/customer')
        ->assertSeeLivewire('admin.customer.customer-index')
        ->assertSeeLivewire('admin.customer.customer-create')
//        ->assertSeeLivewire('admin.customer.customer-edit')
        ->assertSeeLivewire('admin.customer.customer-delete')
        ->assertSeeLivewire('admin.customer.customer-restore')
        ->assertOk();
});

it('lets create a livewire component to list all customers in the page', function () {
    $customers = Customer::factory(10)->create();

    $lw = livewire(CustomerIndex::class)
        ->assertSet('records', function ($data) {
            expect($data)
                ->toBeInstanceOf(Paginator::class)
                ->toHaveCount(10);

            return true;
        });

    foreach ($customers as $customer) {
        $lw->assertSee([
            $customer->name,
            $customer->email,
        ]);
    }
});

it('should be able to filter by name and email', function () {
    Customer::factory(5)
        ->sequence(
            ['name' => 'fulano and test 01 filter', 'email' => 'fulano01@testing.com'],
            ['name' => 'fulano and test 02 filter', 'email' => 'fulano02@testing.com'],
            [],
            [],
            [],
        )
        ->create();

    livewire(CustomerIndex::class)
        ->call('addFilter', 'test 01')
        ->assertSet('records', function ($data) {
            expect($data)
                ->toHaveCount(1);

            return true;
        })
        ->call('addFilter', 'test 02')
        ->assertSet('records', function ($data) {
            expect($data)
                ->toHaveCount(2);

            return true;
        })
        ->call('addFilter', 'fulano02@testing.com')
        ->assertSet('records', function ($data) {
            expect($data)
                ->toHaveCount(2);

            return true;
        })
        ->call('clearFilter')
        ->call('addFilter', 'fulano02@testing.com')
        ->assertSet('records', function ($data) {
            expect($data)
                ->toHaveCount(1);

            return true;
        });
});

it('should be able to filter by status', function () {
    Customer::factory()->create();
    Customer::factory(2)->deleted()->create();

    livewire(CustomerIndex::class)
        ->assertSet('records', function ($data) {
            expect($data)
                ->toHaveCount(1);

            return true;
        })
        ->set('status', 1)
        ->assertSet('records', function ($data) {
            expect($data)
                ->toHaveCount(1);

            return true;
        })
        ->set('status', 2)
        ->assertSet('records', function ($data) {
            expect($data)
                ->toHaveCount(2);

            return true;
        })
        ->set('status', 3)
        ->assertSet('records', function ($data) {
            expect($data)
                ->toHaveCount(3);

            return true;
        });
});

it('should be able to sort by name', function () {
    Customer::factory()->create(['name' => 'First Customer']);
    Customer::factory()->create(['name' => 'Last Customer']);

    livewire(CustomerIndex::class)
        ->assertSet('records', function ($data) {
            expect($data)
                ->first()->name->toBe('First Customer')
                ->and($data)->last()->name->toBe('Last Customer');

            return true;
        })
        ->set('sortDirection', 'desc')
        ->assertSet('records', function ($data) {
            expect($data)
                ->first()->name->toBe('Last Customer')
                ->and($data)->last()->name->toBe('First Customer');

            return true;
        });
});
