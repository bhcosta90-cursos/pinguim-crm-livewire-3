<?php

declare(strict_types = 1);

use App\Models\User;

use function Pest\Laravel\{actingAs};
use function Pest\Livewire\livewire;

it('updates the user password successfully', function () {
    actingAs($user = User::factory()->create());
    $passwordActual = $user->password;

    livewire('profile.update-password-form')
        ->set('password', 'password')
        ->set('current_password', 'password')
        ->set('password_confirmation', 'password')
        ->call('updatePassword')
        ->assertHasNoErrors();

    expect($user->refresh()->password)->not->toBe($passwordActual);
});

it('validation password of the user', function () {
    actingAs(User::factory()->create());

    livewire('profile.update-password-form')
        ->set('password', 'password123')
        ->set('current_password', 'password')
        ->set('password_confirmation', 'password')
        ->call('updatePassword')
        ->assertHasErrors(['password']);
});
