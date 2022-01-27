<?php

declare(strict_types=1);

namespace App\Http\Requests\Rules;

use Illuminate\Validation\Rules\Password;

trait UserTrait
{
    /** @return array<string, array<mixed>> */
    public function baseRules(): array
    {
        // userId 0 means there is no user to ignore on email unique rule
        $user = $this->route('user');
        $userId = $user === null ? 0 : $user->id;

        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', "unique:users,email,{$userId}"],
            'password' => ['required', 'confirmed', Password::min(10)],
        ];
    }
}
