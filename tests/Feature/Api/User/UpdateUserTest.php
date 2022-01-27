<?php

declare(strict_types=1);

namespace Tests\Feature\Api\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;

class UpdateUserTest extends UserTestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_update_user(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        /** @var User $userUpdate */
        $userUpdate = User::factory()->make();
        $expectedData = $userUpdate->only('name', 'email');

        $response = $this->putJson(route('users.update', ['user' => $user->id]), [
            'name' => $userUpdate->name,
            'email' => $userUpdate->email,
            'password' => $password = $this->faker->password(10),
            'password_confirmation' => $password,
            'is_admin' => true,
        ]);

        $user = User::where('email', $userUpdate->email)->firstOrFail();
        $response->assertOk();
        $response->assertJson([
            'data' => $expectedData
        ]);
        $this->assertTrue(Hash::check($password, $user->password));
        $this->assertTrue($user->is_admin);
    }

    public function test_update_user_with_same_data(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $expectedData = $user->only('name', 'email');

        $response = $this->putJson(route('users.update', ['user' => $user->id]), [
            'name' => $user->name,
            'email' => $user->email,
        ]);

        $user = User::where('email', $user->email)->firstOrFail();
        $response->assertOk();
        $response->assertJson([
            'data' => $expectedData
        ]);
    }

    public function test_send_empty_data(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $expectedData = $user->only('name', 'email');

        $response = $this->putJson(route('users.update', ['user' => $user->id]));

        $user = User::where('email', $user->email)->firstOrFail();
        $response->assertOk();
        $response->assertJson([
            'data' => $expectedData
        ]);
    }

    public function test_rejects_when_user_is_not_admin(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->assertLoggedUserIsNotAdmin('put', route('users.update', [$user->id]));
    }

    public function test_not_existing_user(): void
    {
        $response = $this->putJson(route('users.update', ['user' => 'not-existing']));

        $response->assertNotFound();
    }

    public function test_rejects_email_already_taken(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        /** @var User $userUpdate */
        $userUpdate = User::factory()->create();

        $response = $this->putJson(route('users.update', ['user' => $user->id]), [
            'email' => $userUpdate->email,
        ]);

        $response->assertInvalid(['email']);
    }

    public function test_invalid_password_confirmed(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->putJson(route('users.update', ['user' => $user->id]), [
            'password' => $this->faker->password(10),
            'password_confirmation' => $this->faker->password(10),
        ]);

        $response->assertInvalid(['password']);
    }

    public function test_invalid_password_lower_than_10(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->putJson(route('users.update', ['user' => $user->id]), [
            'password' => $password = $this->faker->password(maxLength: 9),
            'password_confirmation' => $password,
        ]);

        $response->assertInvalid(['password']);
    }
}
