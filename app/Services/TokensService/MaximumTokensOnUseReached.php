<?php

declare(strict_types=1);

namespace App\Services\TokensService;

use RuntimeException;

class MaximumTokensOnUseReached extends RuntimeException
{
    public function __construct(private int $limit)
    {
        parent::__construct("Ya se han usado el máximo de {$this->limit} tokens");
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}
