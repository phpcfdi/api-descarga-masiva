<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

final class TokensWithUserTest extends TestCase
{
    use RefreshDatabase;

    /** @var User */
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        /** @var User $user */
        $user = User::factory()->create();
        $this->user = $user;
    }

    private function createToken(): string
    {
        return $this->user->createToken('api')->plainTextToken;
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

        $response->assertStatus(403);
    }
}
