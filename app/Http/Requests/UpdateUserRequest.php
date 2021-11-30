<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    /** @return array<string, array<mixed>> */
    public function rules(): array
    {
        /** @var User $user */
        $user = $this->route('user');
        return [
            'name' => ['sometimes', 'string'],
            'email' => ['sometimes', 'email', "unique:users,email,{$user->id}"],
            'password' => ['sometimes', 'confirmed', Password::min(10)],
        ];
    }
}
