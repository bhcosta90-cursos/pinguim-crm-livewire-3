<?php

declare(strict_types = 1);

use App\Livewire\Auth\Password\Recovery;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;

use function Pest\Laravel\{assertDatabaseCount, assertDatabaseHas, get};
use function Pest\Livewire\livewire;

test('password recovery page loads and contains Livewire component', function () {
    get('/password/recovery')
        ->assertOk()
        ->assertSeeLivewire('auth.password.recovery');
});

it('should be able to request for a password recovery sending notification to the user', function () {
    Notification::fake();

    /** @var User $user */
    $user = User::factory()->create();

    livewire(Recovery::class)
        ->assertDontSee(__('You will receive an email with the password recovery link.'))
        ->set('email', $user->email)
        ->call('submit')
        ->assertSee(__('You will receive an email with the password recovery link.'));

    Notification::assertSentTo(
        $user,
        ResetPasswordNotification::class
    );
});

test('testing email property', function () {
    $data = [
        'required' => (object) ['value' => '', 'rule' => 'required'],
        'email'    => (object) ['value' => 'any email', 'rule' => 'email'],
    ];
    $lw = livewire(Recovery::class);

    foreach ($data as $item) {
        $lw->set('email', $item->value)
            ->call('submit')
            ->assertHasErrors(['email' => $item->rule]);
    }
});

test('needs to create a token when requesting for a password recovery', function () {
    /** @var User $user */
    $user = User::factory()->create();

    livewire(Recovery::class)
        ->set('email', $user->email)
        ->call('submit');

    assertDatabaseCount('password_reset_tokens', 1);
    assertDatabaseHas('password_reset_tokens', ['email' => $user->email]);
});
