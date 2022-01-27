<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next): mixed
    {
        $user = $request->user();
        if (! $user->is_admin) {
            return response(null, 403);
        }
        return $next($request);
    }
}
