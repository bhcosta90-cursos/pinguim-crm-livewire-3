<?php

declare(strict_types = 1);

use function Pest\Laravel\get;

test('password recovery page loads and contains Livewire component', function () {
    get('/password/recovery')
        ->assertOk()
        ->assertSeeLivewire('auth.password.recovery');
});
