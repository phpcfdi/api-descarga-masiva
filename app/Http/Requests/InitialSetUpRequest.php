<?php

declare(strict_types=1);

namespace App\Http\Requests;

class InitialSetUpRequest extends StoreUserRequest
{
    /** @return array<string, array<mixed>> */
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['email'] = ['required', 'email'];
        return $rules;
    }
}
