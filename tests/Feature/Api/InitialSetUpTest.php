<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\InitialSetUp
 */
final class InitialSetUpTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_initial_setup_with_valid_data(): void
    {
        $name = $this->faker->name();
        $email = $this->faker->email();
        $password = $this->faker->password(10);

        $response = $this->postJson(route('initial-set-up'), [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $this->assertSame(204, $response->getStatusCode());

        $user = User::where('email', $email)->first();
        if (null === $user) {
            $this->fail('The user was not created');
        }
        $this->assertTrue($user->is_admin, 'Created user must have administrator privileges');
    }

    public function test_fail_when_user_already_exists(): void
    {
        User::factory()->create();

        $response = $this->postJson(route('initial-set-up'), [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => $password = $this->faker->password(10),
            'password_confirmation' => $password,
        ]);

        $this->assertSame(400, $response->getStatusCode());
    }

    public function test_invalid_missing_data(): void
    {
        $response = $this->postJson(route('initial-set-up'), []);

        $response->assertInvalid(['name', 'email', 'password']);
    }

    public function test_invalid_email(): void
    {
        $response = $this->postJson(route('initial-set-up'), [
            'name' => $this->faker->name(),
            'email' => 'invalid-email',
            'password' => $password = $this->faker->password(10),
            'password_confirmation' => $password,
        ]);

        $response->assertInvalid(['email']);
    }

    public function test_invalid_password_confirmed(): void
    {
        $response = $this->postJson(route('initial-set-up'), [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => $this->faker->password(10),
            'password_confirmation' => $this->faker->password(10),
        ]);

        $response->assertInvalid(['password']);
    }

    public function test_invalid_password_lower_than_10(): void
    {
        $response = $this->postJson(route('initial-set-up'), [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => $password = $this->faker->password(maxLength: 9),
            'password_confirmation' => $password,
        ]);

        $response->assertInvalid(['password']);
    }
}
