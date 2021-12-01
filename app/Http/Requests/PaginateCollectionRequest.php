<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaginateCollectionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<array<mixed>>
     */
    public function rules(): array
    {
        return [
            'limit' => ['sometimes', 'integer', 'min:1', 'max:50'],
            'page' => ['sometimes', 'integer', 'min:1'],
            'sort' => ['sometimes', Rule::in(User::allowedSorts())],
            'search' => ['sometimes', 'string'],
        ];
    }
}
