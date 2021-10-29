<?php

declare(strict_types=1);

namespace App\Services\TokensService;

use App\Models\User;

class TokensService
{
    public const MAX_TOKENS_COUNT = 5;

    public function __construct(private User $user)
    {
    }

    public function createToken(): string
    {
        $maxTokens = $this->getMaxTokens();
        if ($maxTokens > 0 && $this->user->tokens()->count() >= $maxTokens) {
            throw new MaximumTokensOnUseReached($maxTokens);
        }
        return $this->user->createToken('api')->plainTextToken;
    }

    public function delete(int $tokenId): void
    {
        $this->user->tokens()
            ->where('id', $tokenId)
            ->where('tokenable_id', $this->user->id)
            ->delete();
    }

    public function getMaxTokens(): int
    {
        return self::MAX_TOKENS_COUNT;
    }
}
