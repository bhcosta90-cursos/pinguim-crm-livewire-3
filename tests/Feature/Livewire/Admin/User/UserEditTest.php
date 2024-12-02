<?php

declare(strict_types = 1);

use App\Enums\Permission\Can;
use App\Livewire\Admin\User\UserEdit;
use App\Models\{Permission, User};

use function Pest\Laravel\{actingAs, assertDatabaseHas};
use function Pest\Livewire\livewire;

it('forbids unauthorized user from submitting the form', function () {
    actingAs($user = User::factory()->admin()->create());

    livewire(UserEdit::class)
        ->call('loadUser', $user)
        ->call('submit')
        ->assertForbidden();
});

it('allows authorized user to submit the form', function () {
    actingAs(User::factory()->admin()->create());
    $user = User::factory()->create();

    livewire(UserEdit::class)
        ->call('loadUser', $user)
        ->call('submit')
        ->assertOk();
});

it('assigns impersonate permission to the user', function () {
    actingAs(User::factory()->admin()->create());
    $user = User::factory()->create();

    livewire(UserEdit::class)
        ->call('loadUser', $user)
        ->set('permissions', [Can::Impersonate->value])
        ->call('submit')
        ->assertOk();

    assertDatabaseHas('model_permissions', [
        'model_id'      => $user->id,
        'model_type'    => $user->getMorphClass(),
        'permission_id' => Permission::whereName(Can::Impersonate->value)->first()->id,
    ]);
});
