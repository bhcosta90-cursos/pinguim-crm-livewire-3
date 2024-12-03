<?php

declare(strict_types = 1);

use App\Livewire\Admin\Opportunity\OpportunityIndex;
use App\Models\{Opportunity, User};
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
    get('/admin/opportunity')
        ->assertSeeLivewire('admin.opportunity.opportunity-index')
//        ->assertSeeLivewire('admin.opportunity.opportunity-create')
//        ->assertSeeLivewire('admin.opportunity.opportunity-edit')
//        ->assertSeeLivewire('admin.opportunity.opportunity-delete')
//        ->assertSeeLivewire('admin.opportunity.opportunity-restore')
        ->assertOk();
});

it('lets create a livewire component to list all opportunities in the page', function () {
    $opportunities = Opportunity::factory(10)->create();

    $lw = livewire(OpportunityIndex::class)
        ->assertSet('records', function ($data) {
            expect($data)
                ->toBeInstanceOf(Paginator::class)
                ->toHaveCount(10);

            return true;
        });

    foreach ($opportunities as $opportunity) {
        $lw->assertSee([
            $opportunity->name,
            $opportunity->email,
        ]);
    }
});

it('should be able to filter by name and email', function () {
    Opportunity::factory(5)
        ->sequence(
            ['name' => 'fulano and test 01 filter', 'email' => 'fulano01@testing.com'],
            ['name' => 'fulano and test 02 filter', 'email' => 'fulano02@testing.com'],
            [],
            [],
            [],
        )
        ->create();

    livewire(OpportunityIndex::class)
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
    Opportunity::factory()->create();
    Opportunity::factory(2)->deleted()->create();

    livewire(OpportunityIndex::class)
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
    Opportunity::factory()->create(['name' => 'First Opportunity']);
    Opportunity::factory()->create(['name' => 'Last Opportunity']);

    livewire(OpportunityIndex::class)
        ->assertSet('records', function ($data) {
            expect($data)
                ->first()->name->toBe('First Opportunity')
                ->and($data)->last()->name->toBe('Last Opportunity');

            return true;
        })
        ->set('sortDirection', 'desc')
        ->assertSet('records', function ($data) {
            expect($data)
                ->first()->name->toBe('Last Opportunity')
                ->and($data)->last()->name->toBe('First Opportunity');

            return true;
        });
});