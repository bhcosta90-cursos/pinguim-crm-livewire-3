<?php

declare(strict_types = 1);

use App\Livewire\Auth\Password;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;

use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

test('password reset page loads and contains Livewire component', function () {
    get('/password/reset')
        ->assertRedirectToRoute('login');
});

test('need to receive a valid token with a combination with the email and open the page', function () {
    Notification::fake();

    $user = User::factory()->create();

    livewire(Password\Recovery::class)
        ->set('email', $user->email)
        ->call('submit');

    Notification::assertSentTo(
        $user,
        ResetPasswordNotification::class,
        function (ResetPasswordNotification $notification) {
            get(route('password.reset') . '?token=' . $notification->token)
                ->assertSuccessful();

            get(route('password.reset') . '?token=any-token')
                ->assertRedirect(route('login'));

            return true;
        }
    );

});

test('test if is possible to reset the password with the given token', function () {
    Notification::fake();

    $user = User::factory()->create();

    livewire(Password\Recovery::class)
        ->set('email', $user->email)
        ->call('submit');

    Notification::assertSentTo(
        $user,
        ResetPasswordNotification::class,
        function (ResetPasswordNotification $notification) use ($user) {
            livewire(
                Password\Reset::class,
                ['token' => $notification->token, 'email' => $user->email]
            )
                ->set('email_confirmation', $user->email)
                ->set('password', 'new-password')
                ->set('password_confirmation', 'new-password')
                ->call('submit')
                ->assertHasNoErrors()
                ->assertRedirect(route('login'));

            $user->refresh();

            expect(Hash::check('new-password', $user->password))->toBeTrue();

            return true;
        }
    );
});

test('checking form rules', function () {
    Notification::fake();

    $user = User::factory()->create();

    livewire(Password\Recovery::class)
        ->set('email', $user->email)
        ->call('submit');

    Notification::assertSentTo(
        $user,
        ResetPasswordNotification::class,
        function (ResetPasswordNotification $notification) use ($user) {

            $data = [
                'email:required'     => (object) ['field' => 'email', 'value' => '', 'rule' => 'required'],
                'email:confirmed'    => (object) ['field' => 'email', 'value' => 'email@email.com', 'rule' => 'confirmed'],
                'email:email'        => (object) ['field' => 'email', 'value' => 'not-an-email', 'rule' => 'email'],
                'password:required'  => (object) ['field' => 'password', 'value' => '', 'rule' => 'required'],
                'password:confirmed' => (object) ['field' => 'password', 'value' => 'any-password', 'rule' => 'confirmed'],
            ];

            $lw = livewire(Password\Reset::class, ['token' => $notification->token, 'email' => $user->email]);

            foreach ($data as $item) {
                $lw->set($item->field, $item->value)
                    ->call('submit')
                    ->assertHasErrors([$item->field => $item->rule]);
            }

            return true;
        }
    );

});

test('needs to show an obfuscate email to the user', function () {
    $email = 'jeremias@example.com';

    $obfuscatedEmail = obfuscate_email($email);

    expect($obfuscatedEmail)
        ->toBe('je******@********com');

    Notification::fake();

    $user = User::factory()->create();

    livewire(Password\Recovery::class)
        ->set('email', $user->email)
        ->call('submit');

    Notification::assertSentTo(
        $user,
        ResetPasswordNotification::class,
        function (ResetPasswordNotification $notification) use ($user) {
            livewire(Password\Reset::class, ['token' => $notification->token, 'email' => $user->email])
                ->assertSet('obfuscatedEmail', obfuscate_email($user->email));

            return true;
        }
    );
});
