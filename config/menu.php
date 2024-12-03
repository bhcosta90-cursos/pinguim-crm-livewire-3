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
    [
        'title'      => 'Customer',
        'route'      => 'admin.customer.index',
        'permission' => ['viewAny', Models\Customer::class],
    ],
    [
        'title'      => 'Opportunity',
        'route'      => 'admin.opportunity.index',
        'permission' => ['viewAny', Models\Opportunity::class],
    ],
];
