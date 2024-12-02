<?php

declare(strict_types = 1);

use App\Models;

return [
    [
        'title'   => 'Admin',
        'submenu' => [
            [
                'title'      => 'Usuário',
                'route'      => 'admin.user.index',
                'permission' => ['viewAny', Models\User::class],
            ],
        ],
    ],

];
