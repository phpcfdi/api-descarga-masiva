<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Requests\Rules\UserTrait;

class InitialSetUpRequest extends StoreUserRequest
{
    use UserTrait;

    /** @return array<string, array<mixed>> */
    public function rules(): array
    {
        return $this->baseRules();
    }
}
