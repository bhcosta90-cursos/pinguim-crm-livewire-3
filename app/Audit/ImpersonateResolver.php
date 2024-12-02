<?php

declare(strict_types = 1);

namespace App\Audit;

use OwenIt\Auditing\Contracts\{Auditable, Resolver};

class ImpersonateResolver implements Resolver
{
    public static function resolve(Auditable $auditable)
    {
        return session('impersonator');
    }
}
