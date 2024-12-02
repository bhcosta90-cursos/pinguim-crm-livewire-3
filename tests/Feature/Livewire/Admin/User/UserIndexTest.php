<?php

declare(strict_types = 1);

use App\Enums\Permission\Can;
use App\Livewire\Admin\User\UserIndex;
use App\Models\User;

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
    get('/admin/user')->assertOk()
        ->assertSeeLivewire('admin.user.user-index')
        ->assertSeeLivewire('admin.user.user-create')
        ->assertSeeLivewire('admin.user.user-delete')
        ->assertSeeLivewire('admin.user.user-restore');
});

it('making sure that route is protected by the permission be an admin', function () {
    actingAs(User::factory()->make());

    get('/admin/user')
        ->assertForbidden()
        ->assertDontSeeLivewire('admin.users');
});

it('lets create a livewire component to list all users in the page', function () {
    $users = User::factory(10)->create();

    $lw = livewire(UserIndex::class)
        ->assertSet('records', function ($data) {
            expect($data)
                ->toBeInstanceOf(Paginator::class)
                ->toHaveCount(11);

            return true;
        });

    foreach ($users as $user) {
        $lw->assertSee([
            $user->name,
            $user->email,
        ]);
    }
});

it('should be able to filter by name and email', function () {
    User::factory(5)
        ->sequence(
            ['name' => 'fulano and test 01 filter', 'email' => 'fulano01@testing.com'],
            ['name' => 'fulano and test 02 filter', 'email' => 'fulano02@testing.com'],
            [],
            [],
            [],
        )
        ->create();

    livewire(UserIndex::class)
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

it('should be able to filter by permissions', function () {
    User::factory()->withPermission([Can::BeAnAdmin])->create();
    User::factory()->withPermission([Can::Impersonate])->create();

    livewire(UserIndex::class)
        ->assertSet('records', function ($data) {
            expect($data)
                ->toHaveCount(3);

            return true;
        })
        ->set('permissions', [Can::BeAnAdmin->value])
        ->assertSet('records', function ($data) {
            expect($data)
                ->toHaveCount(2);

            return true;
        })
        ->set('permissions', [Can::Impersonate->value])
        ->assertSet('records', function ($data) {
            expect($data)
                ->toHaveCount(1);

            return true;
        })
        ->set('permissions', [Can::BeAnAdmin->value, Can::Impersonate->value])
        ->assertSet('records', function ($data) {
            expect($data)
                ->toHaveCount(3);

            return true;
        });
});

it('should be able to filter by status', function () {
    User::factory(2)->deleted()->create();

    livewire(UserIndex::class)
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
    auth()->user()->update(['name' => 'User admin']);
    User::factory()->create(['name' => 'First User']);

    livewire(UserIndex::class)
        ->assertSet('records', function ($data) {
            expect($data)
                ->first()->name->toBe('First User')
                ->and($data)->last()->name->toBe('User admin');

            return true;
        })
        ->set('sortDirection', 'desc')
        ->assertSet('records', function ($data) {
            expect($data)
                ->first()->name->toBe('User admin')
                ->and($data)->last()->name->toBe('First User');

            return true;
        });
});
