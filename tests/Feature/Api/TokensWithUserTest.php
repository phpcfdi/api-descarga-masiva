<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\User;
use App\Services\TokensService\TokensService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

final class TokensWithUserTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private TokensService $service;

    protected function setUp(): void
    {
        parent::setUp();
        /** @var User $user */
        $user = User::factory()->create();
        $this->user = $user;
        config(['app.api.max-tokens-limit' => 3]);
        $this->service = new TokensService($user);
    }

    private function createToken(): string
    {
        return $this->service->createToken();
    }

    public function test_create_new_token(): void
    {
        $email = $this->user->{'email'};

        $response = $this->postJson(route('tokens.login'), [
            'email' => $email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
    }

    public function test_current_user_by_token(): void
    {
        $token = $this->createToken();
        $response = $this->getJson(route('tokens.current'), ['Authorization' => "Bearer $token"]);
        $response->assertStatus(200);
        $response->assertExactJson($this->user->only('name', 'email', 'is_admin'));
    }

    public function test_revoke_token(): void
    {
        $token = $this->createToken();
        $response = $this->postJson(route('tokens.logout'), [], ['Authorization' => "Bearer $token"]);
        $response->assertStatus(204);
    }

    public function test_access_with_invalid_password(): void
    {
        $response = $this->postJson(route('tokens.login'), [
            'email' => $this->user->{'email'},
            'password' => 'not-the-password',
        ]);

        $response->assertStatus(401);
    }

    public function test_maximum_number_of_tokens_reached(): void
    {
        $tokensLimit = $this->service->getMaxTokens();
        for ($i = 0; $i < $tokensLimit; $i++) {
            $this->service->createToken();
        }

        $response = $this->postJson(route('tokens.login'), [
            'email' => $this->user->{'email'},
            'password' => 'password',
        ]);

        $response->assertStatus(400);
    }
}
