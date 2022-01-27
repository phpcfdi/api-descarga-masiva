<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Requests\Rules\UserTrait;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    use UserTrait;

    /** @return array<string, array<mixed>> */
    public function rules(): array
    {
        $rules = $this->baseRules();
        $rules['is_admin'] = ['required', 'bool'];
        return $rules;
    }
}
