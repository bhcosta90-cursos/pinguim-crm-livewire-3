<?php

declare(strict_types = 1);

use App\Livewire\Dev\Login;
use App\Models\User;

use function Pest\Laravel\{actingAs, assertAuthenticatedAs, get};
use function Pest\Livewire\livewire;

it('should be able to list all users of the system', function () {
    User::factory()->count(10)->create();

    $users = User::query()
        ->orderBy('id')
        ->get()
        ->map(function (User $user): array {
            return [
                'value' => $user->id,
                'label' => $user->name,
            ];
        })->toArray();

    livewire(Login::class)
        ->assertSet('options', $users)
        ->assertSee($users[0]['value']);
});

it('should be able to login with any user', function () {
    $user = User::factory()->create();

    livewire(Login::class)
        ->set('selectedUser', $user->id)
        ->assertRedirect(route('dashboard'));

    assertAuthenticatedAs($user);
});

it('should log out the user when selectedUser is set to null', function () {
    $user = User::factory()->create();
    auth()->login($user);

    livewire(Login::class)
        ->set('selectedUser', null)
        ->assertRedirect(route('login'));

    expect(auth()->check())->toBeFalse();
});

it('should not load the livewire component on production environment', function () {
    $user = User::factory()->create();

    app()->detectEnvironment(fn () => 'production');

    actingAs($user);

    get(route('dashboard')) // app.blade.php
        ->assertDontSeeLivewire('dev.login');

    get(route('login')) // guest.blade.php
        ->assertDontSeeLivewire('dev.login');
});

it('should load the livewire component on non production environments', function () {
    $user = User::factory()->create();

    app()->detectEnvironment(fn () => 'local');

    get(route('login')) // guest.blade.php
        ->assertSeeLivewire('dev.login');

    actingAs($user);

    get(route('dashboard')) // app.blade.php
        ->assertSeeLivewire('dev.login');
});
