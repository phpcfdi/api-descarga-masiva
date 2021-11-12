<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class SystemHasNotBeenSetUp
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (User::count() > 0) {
            return response(null, 400);
        }

        return $next($request);
    }
}
