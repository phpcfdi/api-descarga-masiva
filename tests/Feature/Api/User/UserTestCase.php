<?php

declare(strict_types=1);

namespace Tests\Feature\Api\User;

use App\Models\User;
use Tests\TestCase;

class UserTestCase extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        /** @var User $user */
        $user = User::factory()->admin()->create();
        $this->user = $user;
        $this->actingAs($this->user);
    }

    public function assertLoggedUserIsNotAdmin(string $method, string $route): void
    {
        $this->user->is_admin = false;
        $this->user->save();

        $response = $this->{"${method}Json"}($route);

        $response->assertForbidden();
    }
}
