<?php

declare(strict_types = 1);

use App\Enums\Permission\Can;
use App\Livewire\Admin\User\UserCreate;
use App\Models\{Permission, User};

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas};
use function Pest\Livewire\livewire;

beforeEach(fn () => actingAs($this->user = User::factory()->admin()->create()));

it('creates a user with impersonate permission and dispatches user index event', function () {
    livewire(UserCreate::class)
        ->set('slide', true)
        ->set([
            'user' => [
                'name'  => 'Testing',
                'email' => 'test@gmail.com',
            ],
            'password' => '12345678',
        ])
        ->set('permissions', [Can::Impersonate->value])
        ->call('submit')
        ->assertOk()
        ->assertDispatched('user::index');

    $user = User::whereEmail('test@gmail.com')->first();

    assertDatabaseCount('model_permissions', 2);
    assertDatabaseHas('model_permissions', [
        'model_id'      => $user->id,
        'model_type'    => $user->getMorphClass(),
        'permission_id' => Permission::whereName(Can::Impersonate->value)->first()->id,
    ]);
});

it('validation fields to create a new user', function () {
    $lw = livewire(UserCreate::class)
        ->set('slide', true);

    $data = [
        'name::required'     => (object)['field' => 'user.name', 'value' => '', 'rule' => 'required'],
        'name::min:3'        => (object)['field' => 'user.name', 'value' => 'a', 'rule' => 'min'],
        'name::max:255'      => (object)['field' => 'user.name', 'value' => str_repeat('*', 256), 'rule' => 'max'],
        'email::required'    => (object)['field' => 'user.email', 'value' => '', 'rule' => 'required'],
        'email::email'       => (object)['field' => 'user.email', 'value' => 'not-an-email', 'rule' => 'email'],
        'email::max:255'     => (object)['field' => 'user.email', 'value' => str_repeat('*' . '@doe.com', 256), 'rule' => 'max'],
        'email::unique'      => (object)['field' => 'user.email', 'value' => 'joe@doe.com', 'rule' => 'unique'],
        'password::required' => (object)['field' => 'password', 'value' => '', 'rule' => 'required'],
        'password::min'      => (object)['field' => 'password', 'value' => '1', 'rule' => 'min'],
        'password::max'      => (object)['field' => 'password', 'value' => str_repeat('*', 21), 'rule' => 'max'],
    ];

    foreach ($data as $f) {
        if ($f->rule === 'unique') {
            $field = explode('.', $f->field);
            $field = array_pop($field);
            User::factory()->create([$field => $f->value]);
        }

        $lw->set($f->field, $f->value);

        $lw->call('submit')
            ->assertHasErrors([$f->field => $f->rule]);
    }
});
