<?php

declare(strict_types = 1);

namespace App\Enums\Permission;

enum Can: string
{
    case BeAnAdmin   = 'be-an-admin';
    case Impersonate = 'impersonate';
}
