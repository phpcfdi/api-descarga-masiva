<?php

declare(strict_types=1);

use App\Http\Controllers\Api;
use App\Http\Middleware\SystemHasNotBeenSetUp;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

// unprotected routes
Route::post('/tokens/login', [Api\TokensController::class, 'create'])->name('tokens.login');
Route::post('/initial-set-up', Api\InitialSetUp::class)
    ->middleware(SystemHasNotBeenSetUp::class)
    ->name('initial-set-up');

// protected by token routes
Route::middleware(['auth:sanctum'])->group(function (Router $route): void {
    $route->post('/tokens/logout', [Api\TokensController::class, 'delete'])->name('tokens.logout');
    $route->get('/tokens/current', [Api\TokensController::class, 'current'])->name('tokens.current');

    $route->middleware(['admin'])->group(function (Router $route): void {
        $route->apiResource('users', Api\UserController::class);
    });
});
