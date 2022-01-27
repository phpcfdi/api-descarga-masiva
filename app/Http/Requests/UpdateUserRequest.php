<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Requests\Rules\UserTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    use UserTrait;

    /** @return array<string, array<mixed>> */
    public function rules(): array
    {
        $rules = $this->baseRules();
        foreach ($rules as $field => $fieldRules) {
            array_unshift($fieldRules, 'sometimes');
            $rules[$field] = $fieldRules;
        }
        $rules['is_admin'] = ['sometimes', 'bool'];
        return $rules;
    }
}
