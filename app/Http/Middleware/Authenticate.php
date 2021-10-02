<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo(mixed $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        return route('login');
    }
}
