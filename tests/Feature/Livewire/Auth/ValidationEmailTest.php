<?php

declare(strict_types = 1);

use App\Livewire\Auth\{Register, ValidationEmail};
use App\Models\User;
use App\Notifications\ValidationCodeNotification;

use function Pest\Laravel\{actingAs, get};

beforeEach(function () {
    Notification::fake();
});

it('should redirect to the validation page after registration', function () {
    Livewire::test(Register::class)
        ->set('name', 'Joe doe')
        ->set('email', 'joe@doe.com')
        ->set('email_confirmation', 'joe@doe.com')
        ->set('password', 'password')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertRedirect(route('email-validation'));
});

it('should check if the code is valid', function () {
    $user = User::factory()->withValidationCode()->create();

    actingAs($user);

    Livewire::test(ValidationEmail::class)
        ->set('code', '000001')
        ->call('submit')
        ->assertHasErrors(['code']);
});

it('should be able to send a new code to the user', function () {
    $user    = User::factory()->withValidationCode()->create();
    $oldCode = $user->validation_code;

    actingAs($user);

    Livewire::test(ValidationEmail::class)
        ->call('sendNewCode');

    expect($user)->validation_code->not->toBe($oldCode);
    Notification::assertSentTo($user, ValidationCodeNotification::class);
});

it('should update email_verified_at and delete the code if the code if valid', function () {
    $user = User::factory()
        ->withValidationCode()
        ->create();

    actingAs($user);

    Livewire::test(ValidationEmail::class)
        ->set('code', '000000')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard'));

    expect($user)
        ->email_verified_at->not->toBeNull()
        ->validation_code->toBeNull();
});

it('should redirect to the email-verification if email_verified_at is null and the user is logged in', function () {
    $user = User::factory()->withValidationCode()->create();

    actingAs($user);

    get(route('dashboard'))
        ->assertRedirect(route('email-validation'));
});
