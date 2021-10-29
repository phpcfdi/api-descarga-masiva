<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

final class TokensWithoutUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_access_protected_routes_without_token(): void
    {
        $response = $this->postJson(route('tokens.logout'));
        $response->assertStatus(401);

        $response = $this->getJson(route('tokens.current'));
        $response->assertStatus(401);
    }

    public function test_cannot_access_protected_routes_with_invalid_token(): void
    {
        $this->withHeader('Authorization', 'Bearer: 1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');

        $response = $this->postJson(route('tokens.logout'));
        $response->assertStatus(401);

        $response = $this->getJson(route('tokens.current'));
        $response->assertStatus(401);
    }

    public function test_access_without_data(): void
    {
        $response = $this->postJson(route('tokens.login'), []);

        $response->assertStatus(422);
    }

    public function test_access_with_invalid_credential(): void
    {
        $response = $this->postJson(route('tokens.login'), [
            'email' => 'non.existent@email.tld',
            'password' => 'not-the-password',
        ]);

        $response->assertStatus(403);
    }
}
