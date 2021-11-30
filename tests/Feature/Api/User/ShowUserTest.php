<?php

declare(strict_types=1);

namespace Tests\Feature\Api\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowUserTest extends UserTestCase
{
    use RefreshDatabase;

    public function test_show_user(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $expectedData = $user->only('name', 'email');

        $response = $this->getJson(route('users.show', ['user' => $user->id]));

        $response->assertOk();
        $response->assertJson([
            'data' => $expectedData
        ]);
    }

    public function test_rejects_when_user_is_not_admin(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->assertLoggedUserIsNotAdmin('get', route('users.store', [$user->id]));
    }

    public function test_not_existing_user(): void
    {
        $response = $this->getJson(route('users.show', ['user' => 'not-existing']));

        $response->assertNotFound();
    }
}
