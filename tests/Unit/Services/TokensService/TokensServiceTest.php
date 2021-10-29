<?php

declare(strict_types=1);

namespace Tests\Unit\Services\TokensService;

use App\Models\User;
use App\Services\TokensService\MaximumTokensOnUseReached;
use App\Services\TokensService\TokensService;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

final class TokensServiceTest extends TestCase
{
    use RefreshDatabase;

    private TokensService $service;

    protected function setUp(): void
    {
        parent::setUp();
        /** @var User $user */
        $user = User::factory()->create();
        $this->service = new TokensService($user, 2);
    }

    /** @return array<string, array<mixed>> */
    public function provider_service_uses_configured_max_tokens_limit(): array
    {
        $defaultMaxTokensLimit = TokensService::DEFAULT_MAX_TOKENS_LIMIT;
        return [
            'no config' => [null, $defaultMaxTokensLimit, true, $defaultMaxTokensLimit],
            'positive' => [1, 1, true, 1],
            'zero' => [0, 0, false, 0],
            'negative' => [-1, -1, false, 0],
        ];
    }

    /** @dataProvider provider_service_uses_configured_max_tokens_limit */
    public function test_service_uses_configured_max_tokens_limit(
        ?int $limitValue,
        int $configuredMaxTokens,
        bool $isMaxTokensEnabled,
        int $maxTokens
    ): void {
        config(['app.api.max-tokens-limit' => $limitValue]);
        $this->assertSame($configuredMaxTokens, TokensService::configuredMaxTokens());

        $service = new TokensService($this->createMock(User::class), $limitValue);
        $this->assertSame($isMaxTokensEnabled, $service->isMaxTokensEnabled());
        $this->assertSame($maxTokens, $service->getMaxTokens());
    }

    public function test_create_token_respect_limit(): void
    {
        // create all tokens
        $tokensLimit = $this->service->getMaxTokens();
        for ($i = 0; $i < $tokensLimit; $i++) {
            $this->service->createToken();
        }

        // next create token must throw an exception
        $this->expectException(MaximumTokensOnUseReached::class);
        $this->service->createToken();
    }

    public function test_token_is_deleted(): void
    {
        $token = $this->service->createToken();
        $tokenId = (int) Str::before($token, '|');
        $this->assertDatabaseHas('personal_access_tokens', ['id' => $tokenId]);
        $this->service->delete($tokenId);
        $this->assertDatabaseMissing('personal_access_tokens', ['id' => $tokenId]);
    }
}
