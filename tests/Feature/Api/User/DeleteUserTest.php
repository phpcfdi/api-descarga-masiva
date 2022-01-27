<?php

declare(strict_types=1);

namespace Tests\Feature\Api\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteUserTest extends UserTestCase
{
    use RefreshDatabase;

    public function test_delete_user(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->deleteJson(route('users.show', ['user' => $user->id]));

        $response->assertNoContent();
        $this->assertDeleted($user);
    }

    public function test_rejects_when_user_is_not_admin(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->assertLoggedUserIsNotAdmin('delete', route('users.destroy', [$user->id]));
    }

    public function test_not_existing_user(): void
    {
        $response = $this->deleteJson(route('users.destroy', ['user' => 'not-existing']));

        $response->assertNotFound();
    }
}
