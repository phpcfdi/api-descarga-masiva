<?php

declare(strict_types=1);

use App\Http\Controllers\Api;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

// unprotected routes
Route::post('/tokens/login', [Api\TokensController::class, 'create'])->name('tokens.login');

// protected by token routes
Route::middleware(['auth:sanctum'])->group(function (Router $route): void {
    $route->post('/tokens/logout', [Api\TokensController::class, 'delete'])->name('tokens.logout');
    $route->get('/tokens/current', [Api\TokensController::class, 'current'])->name('tokens.current');
});
