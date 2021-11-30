<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array<mixed>|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(mixed $request): mixed
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
