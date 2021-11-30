<?php

declare(strict_types=1);

namespace Tests\Feature\Api\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;

class StoreUserTest extends UserTestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_store_user(): void
    {
        /** @var User $user */
        $user = User::factory()->make();
        $expectedData = $user->only('name', 'email');

        $response = $this->postJson(route('users.store'), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $password = $this->faker->password(10),
            'password_confirmation' => $password,
        ]);

        $user = User::where('email', $user->email)->firstOrFail();
        $response->assertCreated();
        $response->assertJson([
            'data' => $expectedData
        ]);
        $this->assertDatabaseHas('users', $expectedData);
        $this->assertTrue(Hash::check($password, $user->password));
    }

    public function test_rejects_when_user_is_not_admin(): void
    {
        $this->assertLoggedUserIsNotAdmin('post', route('users.store'));
    }

    public function test_send_empty_request(): void
    {
        $response = $this->postJson(route('users.store'));

        $response->assertInvalid(['name', 'email', 'password']);
    }

    public function test_invalid_email(): void
    {
        $response = $this->postJson(route('users.store'), [
            'name' => $this->faker->name(),
            'email' => 'invalid-email',
            'password' => $password = $this->faker->password(10),
            'password_confirmation' => $password,
        ]);

        $response->assertInvalid(['email']);
    }

    public function test_invalid_password_confirmed(): void
    {
        $response = $this->postJson(route('users.store'), [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => $this->faker->password(10),
            'password_confirmation' => $this->faker->password(10),
        ]);

        $response->assertInvalid(['password']);
    }

    public function test_invalid_password_lower_than_10(): void
    {
        $response = $this->postJson(route('users.store'), [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => $password = $this->faker->password(maxLength: 9),
            'password_confirmation' => $password,
        ]);

        $response->assertInvalid(['password']);
    }

    public function test_email_already_taken(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->postJson(route('users.store'), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $password = $this->faker->password(10),
            'password_confirmation' => $password,
        ]);

        $response->assertInvalid(['email']);
    }
}
