<?php

declare(strict_types = 1);

use App\Livewire\Admin\User\UserRestore;
use App\Models\User;

use function Pest\Laravel\{actingAs, assertNotSoftDeleted};
use function Pest\Livewire\livewire;

it('should soft delete an user', function () {
    actingAs(User::factory()->admin()->create());

    $user = User::factory()->deleted()->create();

    livewire(UserRestore::class)
        ->call('confirm', $user->id)
        ->call('execute');

    assertNotSoftDeleted($user);
});
