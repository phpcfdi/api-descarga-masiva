<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateTokenRequest;
use App\Models\User;
use App\Services\TokensService\MaximumTokensOnUseReached;
use App\Services\TokensService\TokensService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class TokensController
{
    public function create(CreateTokenRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        Auth::once($credentials);

        /** @var User|null $user */
        $user = Auth::user();
        if ($user === null) {
            throw new UnauthorizedHttpException('Bearer', 'Datos de usuario y contraseña incorrectos.');
        }

        $service = $this->createTokensService($user);

        try {
            $token = $service->createToken();
        } catch (MaximumTokensOnUseReached $exception) {
            throw new BadRequestHttpException($exception->getMessage(), $exception);
        }

        return new JsonResponse(['token' => $token]);
    }

    public function current(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        return new JsonResponse($user->only('name', 'email', 'is_admin'));
    }

    public function delete(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $service = $this->createTokensService($user);
        $tokenId = intval(Str::before($request->bearerToken() ?? '', '|'));

        $service->delete($tokenId);

        return new JsonResponse(status: 204);
    }

    private function createTokensService(User $user): TokensService
    {
        return new TokensService($user);
    }
}
