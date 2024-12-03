<?php

declare(strict_types = 1);

use App\Livewire\Profile\UpdateProfileInformationForm;
use App\Models\User;
use App\Notifications\ValidationCodeNotification;
use Illuminate\Support\Facades\Auth;

use function Pest\Livewire\livewire;

it('updates the profile information successfully', function () {
    Notification::fake();

    $user = User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    Auth::login($user);

    ($lw = livewire(UpdateProfileInformationForm::class))
        ->set('name', 'New Name')
        ->set('email', 'newemail@example.com')
        ->set('password', 'password')
        ->call('updateProfileInformation')
        ->assertHasNoErrors()
        ->assertSee(__('Your email address is unverified.'));

    $user->refresh();

    expect($user->name)->toBe('New Name')
        ->and($user->email)->toBe('newemail@example.com')
        ->and($user->email_verified_at)->toBeNull();

    $lw->call('sendVerification');

    Notification::assertSentTo($user, ValidationCodeNotification::class, function ($event) use ($user, $lw) {
        $lw->set('password', 'password')
            ->set('code', $event->code)
            ->call('updateProfileInformation')
            ->assertHasNoErrors();

        expect($user->refresh())->email_verified_at->not->toBeNull()
            ->validation_code->toBeNull()
            ->validation_at->toBeNull();

        return true;
    });
});

it('throws validation error for incorrect current password', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    Auth::login($user);

    livewire(UpdateProfileInformationForm::class)
        ->set('name', 'New Name')
        ->set('email', 'newemail@example.com')
        ->set('password', 'password_2')
        ->call('updateProfileInformation')
        ->assertHasErrors(['password' => 'current_password']);
});
