<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginateCollectionRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @return UserCollection<User>
     */
    public function index(PaginateCollectionRequest $request): UserCollection
    {
        $limit = (int) $request->has('limit') ? $request->input('limit') : 30;
        $page = (int) $request->has('page') ? $request->input('page') : 1;
        $sort = $request->has('sort') ? $request->input('sort') : null;
        $offset = ($limit * $page) - $limit;
        $search = $request->has('search') ? $request->input('search') : null;
        if ($search) {
            $query = User::where('email', 'like', "%${search}%")->orWhere('name', 'LIKE', "%${search}%");
        } else {
            $query = User::limit($limit);
        }
        $total = $query->count();
        if ($sort) {
            $order = str_contains($sort, '-') ? 'desc' : 'asc';
            /** @var string $cleanedSort */
            $cleanedSort = str_replace('-', '', $sort);
            $query = $query->orderBy($cleanedSort, $order);
        }
        $userCollection = $offset > 0 ? $query->offset((int) $offset)->get() : $query->get();
        return new UserCollection($userCollection, $total);
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    public function store(StoreUserRequest $request): UserResource
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'is_admin' => false,
        ]);
        return new UserResource($user);
    }

    public function update(User $user, UpdateUserRequest $request): UserResource
    {
        $data = $request->validated();
        if ($request->has('password')) {
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);
        return new UserResource($user);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return new JsonResponse(null, 204);
    }
}
