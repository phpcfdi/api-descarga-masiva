<?php

declare(strict_types=1);

namespace Tests\Feature\Api\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;

class PaginateUserTest extends UserTestCase
{
    use RefreshDatabase;

    /**
     *
     * @param array<string, mixed> $expectedCollection
     */
    public function assertPaginatedResponse(TestResponse $response, array $expectedCollection, int $total): void
    {
        $response->assertOk();
        $response->assertJsonFragment(
            [
                'data' => [$expectedCollection]
            ]
        );
        $response->assertJsonFragment(['total' => $total]);
    }

    public function test_default_pagination(): void
    {
        User::factory()->count(10)->create();
        $response = $this->getJson(route('users.index'));
        $expectedResponse = User::select('id', 'name', 'email')->paginate(30)->toArray();

        $this->assertPaginatedResponse($response, $expectedResponse['data'], 11);
    }

    public function test_search_name(): void
    {
        User::factory()->count(10)->create();
        /** @var User $user */
        $user = User::factory()->create([
            'name' => 'mi nombre'
        ]);
        $response = $this->getJson(route('users.index', ['search' => 'mi nomb']));

        $expectedResponse = User::select('id', 'name', 'email')->where('name', 'mi nombre')->paginate(30)->toArray();

        $this->assertPaginatedResponse($response, $expectedResponse['data'], 1);
    }

    public function test_search_non_existing(): void
    {
        User::factory()->count(10)->create([
            'name' => 'un nombre'
        ]);

        $response = $this->getJson(route('users.index', ['search' => 'non existing']));

        $expectedResponse = User::select('id', 'name', 'email')->where('name', 'non existing')->paginate(30)->toArray();

        $this->assertPaginatedResponse($response, $expectedResponse['data'], 0);
    }

    public function test_search_email(): void
    {
        User::factory()->count(10)->create();
        User::factory()->create([
            'email' => 'example@example.com',
        ]);
        $response = $this->getJson(route('users.index', ['search' => 'example@']));

        $expectedResponse = User::select('id', 'name', 'email')->where('email', 'example@example.com')
            ->paginate(30)->toArray();

            $this->assertPaginatedResponse($response, $expectedResponse['data'], 1);
    }

    public function test_order_by(): void
    {
        User::factory()->count(10)->create();
        $response = $this->getJson(route('users.index', ['sort' => '-name']));

        $expectedResponse = User::select('id', 'name', 'email')->orderBy('name', 'desc')
            ->paginate(30)->toArray();

            $this->assertPaginatedResponse($response, $expectedResponse['data'], 11);
    }

    public function test_limit_and_page(): void
    {
        User::factory()->count(10)->create();
        $response = $this->getJson(route('users.index', ['sort' => 'name', 'limit' => 1, 'page' => 2]));
        $expectedResponse = User::select('id', 'name', 'email')
            ->orderBy('name', 'asc')
            ->paginate(perPage: 1, page: 2)
            ->toArray();

            $this->assertPaginatedResponse($response, $expectedResponse['data'], 11);
    }

    public function test_send_bad_limit_and_page(): void
    {
        $response = $this->getJson(route('users.index', ['limit' => 0, 'page' => 0]));

        $response->assertInvalid(['limit', 'page']);
    }

    public function test_send_bad_sort_field(): void
    {
        $response = $this->getJson(route('users.index', ['sort' => 'not-allowed',]));

        $response->assertInvalid(['sort']);
    }
}
