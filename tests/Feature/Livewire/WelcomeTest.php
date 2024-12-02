<?php

declare(strict_types = 1);

use function Pest\Laravel\get;

test('it displays the welcome component', function () {
    get('/')
        ->assertOk()
        ->assertSeeLivewire('welcome');
});
