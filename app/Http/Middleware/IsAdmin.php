<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next): mixed
    {
        /** @var User|null $user */
        $user = $request->user();
        if ($user && ! $user->is_admin) {
            return response(null, 403);
        }
        return $next($request);
    }
}
