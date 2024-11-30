<?php

declare(strict_types = 1);

use function Pest\Laravel\get;

test('password reset page loads and contains Livewire component', function () {
    get('/password/reset')
        ->assertOk()
        ->assertSeeLivewire('auth.password.reset');
});
