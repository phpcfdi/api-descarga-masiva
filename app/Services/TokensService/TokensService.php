<?php

declare(strict_types=1);

namespace App\Services\TokensService;

use App\Models\User;

class TokensService
{
    public const DEFAULT_MAX_TOKENS_LIMIT = 5;
    private int $maxTokens;

    public function __construct(private User $user, ?int $maxTokens = null)
    {
        $this->maxTokens = max(0, $maxTokens ?? self::configuredMaxTokens());
    }

    public static function configuredMaxTokens(): int
    {
        return (int) (config('app.api.max-tokens-limit') ?? self::DEFAULT_MAX_TOKENS_LIMIT);
    }

    public function createToken(): string
    {
        $maxTokens = $this->getMaxTokens();
        if ($this->isMaxTokensEnabled() && $this->user->tokens()->count() >= $maxTokens) {
            throw new MaximumTokensOnUseReached($maxTokens);
        }
        return $this->user->createToken('api')->plainTextToken;
    }

    public function delete(int $tokenId): void
    {
        $this->user->tokens()
            ->where('id', $tokenId)
            ->where('tokenable_id', $this->user->{'id'})
            ->delete();
    }

    public function isMaxTokensEnabled(): bool
    {
        return $this->maxTokens > 0;
    }

    public function getMaxTokens(): int
    {
        return $this->maxTokens;
    }
}
