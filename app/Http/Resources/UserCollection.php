<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    public function __construct(mixed $resource, private ?int $total = null)
    {
        parent::__construct($resource);
    }
    /**
     * Transform the resource collection into an array.
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
            'data' => $this->collection,
            'total' => $this->total ?? $this->count(),
        ];
    }
}
