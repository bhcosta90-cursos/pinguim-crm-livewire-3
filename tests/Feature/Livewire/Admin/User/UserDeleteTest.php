<?php

declare(strict_types = 1);

use App\Livewire\Admin\User\UserDelete;
use App\Models\User;

use function Pest\Laravel\{actingAs, assertSoftDeleted};
use function Pest\Livewire\livewire;

it('should soft delete an user', function () {
    actingAs(User::factory()->admin()->create());

    $user = User::factory()->create();

    livewire(UserDelete::class)
        ->call('confirm', $user->id)
        ->call('execute');

    assertSoftDeleted($user);
});
