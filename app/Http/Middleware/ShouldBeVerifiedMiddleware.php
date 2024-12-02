<?php

declare(strict_types = 1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ShouldBeVerifiedMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->email_verified_at == null) {
            return to_route('email-validation');
        }

        return $next($request);
    }
}
