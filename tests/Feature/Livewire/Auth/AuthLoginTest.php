<?php

declare(strict_types = 1);

use App\Livewire\Auth\Login;
use App\Models\User;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

it('renders successfully', function () {
    get('login')
        ->assertOk()
        ->assertSeeLivewire('auth.login');
});

it('should be able to login', function () {
    $user = User::factory()->create([
        'email'    => 'joe@doe.com',
        'password' => 'password',
    ]);

    livewire(Login::class)
        ->set('email', 'joe@doe.com')
        ->set('password', 'password')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard'));

    expect(auth()->check())->toBeTrue()
        ->and(auth()->user())->id->toBe($user->id);
});

it('should make sure to inform the user an error when email and password doesnt work', function () {
    livewire(Login::class)
        ->set('email', 'joe@doe.com')
        ->set('password', 'password')
        ->call('submit')
        ->assertHasErrors(['invalidCredentials'])
        ->assertSee(trans('auth.failed'));
});

it('should make sure that the rate limiting is blocking after 5 attempts', function () {
    $user = User::factory()->create();

    $lw = livewire(Login::class);

    for ($i = 0; $i < 5; $i++) {
        $lw->set('email', $user->email)
            ->set('password', 'wrong-password')
            ->call('submit')
            ->assertHasErrors(['invalidCredentials']);
    }

    $lw->set('email', $user->email)
        ->set('password', 'wrong-password')
        ->call('submit')
        ->assertHasErrors(['rateLimiter']);
});
