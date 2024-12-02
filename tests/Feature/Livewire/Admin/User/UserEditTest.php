<?php

declare(strict_types = 1);

use App\Enums\Permission\Can;
use App\Livewire\Admin\User\UserEdit;
use App\Models\{Permission, User};

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas};
use function Pest\Livewire\livewire;

beforeEach(fn () => actingAs($this->user = User::factory()->admin()->create()));

it('forbids unauthorized user from submitting the form', function () {
    livewire(UserEdit::class)
        ->call('loadUser', $this->user)
        ->call('submit')
        ->assertForbidden();
});

it('allows authorized user to submit the form', function () {
    $user = User::factory()->create();

    livewire(UserEdit::class)
        ->call('loadUser', $user)
        ->call('submit')
        ->assertOk();
});

it('assigns impersonate permission to the user', function () {
    $user = User::factory()->create();

    livewire(UserEdit::class)
        ->call('loadUser', $user)
        ->set('permissions', [Can::Impersonate->value])
        ->call('submit')
        ->assertOk();

    assertDatabaseCount('model_permissions', 2);
    assertDatabaseHas('model_permissions', [
        'model_id'      => $user->id,
        'model_type'    => $user->getMorphClass(),
        'permission_id' => Permission::whereName(Can::Impersonate->value)->first()->id,
    ]);
});
