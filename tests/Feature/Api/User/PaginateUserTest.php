<?php

declare(strict_types=1);

namespace Tests\Feature\Api\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaginateUserTest extends UserTestCase
{
    use RefreshDatabase;

    public function test_default_pagination(): void
    {
        User::factory()->count(10)->create();
        $response = $this->getJson(route('users.index'));

        $response->assertOk();
        $response->assertExactJson([
            'data' => User::select('id', 'name', 'email')->get()->toArray(),
            'total' => User::count(),
        ]);
    }

    public function test_search_name(): void
    {
        User::factory()->count(10)->create();
        /** @var User $user */
        $user = User::factory()->create([
            'name' => 'mi nombre'
        ]);
        $response = $this->getJson(route('users.index', ['search' => 'mi nomb']));

        $response->assertOk();
        $response->assertExactJson([
            'data' => [$user->only('id', 'name', 'email')],
            'total' => 1,
        ]);
    }

    public function test_search_non_existing(): void
    {
        User::factory()->count(10)->create();

        $response = $this->getJson(route('users.index', ['search' => 'non existing']));

        $response->assertOk();
        $response->assertExactJson([
            'data' => [],
            'total' => 0,
        ]);
    }

    public function test_search_email(): void
    {
        User::factory()->count(10)->create();
        /** @var User $user */
        $user = User::factory()->create([
            'email' => 'example@example.com'
        ]);
        $response = $this->getJson(route('users.index', ['search' => 'example@']));

        $response->assertOk();
        $response->assertExactJson([
            'data' => [$user->only('id', 'name', 'email')],
            'total' => 1,
        ]);
    }

    public function test_order_by(): void
    {
        User::factory()->count(10)->create();
        $response = $this->getJson(route('users.index', ['sort' => '-name']));

        $response->assertOk();
        $response->assertExactJson([
            'data' => User::select('id', 'name', 'email')->orderBy('name', 'desc')->get()->toArray(),
            'total' => User::count(),
        ]);
    }

    public function test_limit_and_page(): void
    {
        User::factory()->count(10)->create();
        $response = $this->getJson(route('users.index', ['sort' => 'name', 'limit' => 5, 'page' => 2]));

        $response->assertOk();
        $response->assertExactJson([
            'data' => User::select('id', 'name', 'email')->orderBy('name', 'asc')
                ->limit(5)->offset(5)->get()->toArray(),
            'total' => User::count(),
        ]);
    }

    public function test_send_bad_limit_and_page(): void
    {
        $response = $this->getJson(route('users.index', ['limit' => 0, 'page' => 0]));

        $response->assertInvalid(['limit', 'page']);
    }

    public function test_send_bad_sort_field(): void
    {
        $response = $this->getJson(route('users.index', ['sort' => 'not-allowed', ]));

        $response->assertInvalid(['sort']);
    }
}
