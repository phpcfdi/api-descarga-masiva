<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\InitialSetUpRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class InitialSetUp
{
    public function __invoke(InitialSetUpRequest $request): JsonResponse
    {
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'is_admin' => true,
        ]);

        return new JsonResponse(null, 204);
    }
}
