<?php

declare(strict_types = 1);

use App\Models\User;

use function Pest\Laravel\{actingAs, assertSoftDeleted};
use function Pest\Livewire\livewire;

it('deletes the user and logs out successfully', function () {
    actingAs($user = User::factory()->create());

    livewire('profile.delete-user-form')
        ->set('password', 'password')
        ->call('confirm')
        ->call('execute')
        ->assertHasNoErrors();

    assertSoftDeleted($user);
    expect(auth()->check())->toBeFalse();
});

it('validation password of the user', function () {
    actingAs(User::factory()->create());

    livewire('profile.delete-user-form')
        ->set('password', 'password123')
        ->call('confirm')
        ->assertHasErrors(['password']);
});
