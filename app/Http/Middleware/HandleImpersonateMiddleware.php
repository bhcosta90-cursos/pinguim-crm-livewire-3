<?php

declare(strict_types = 1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HandleImpersonateMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('impersonate') && $id = session()->get('impersonate')) {
            auth()->onceUsingId($id);
        }

        return $next($request);
    }
}
