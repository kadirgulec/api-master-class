<?php

use App\Http\Controllers\Api\V1\AuthorsController;
use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\UsersController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->name('api.v1.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('tickets', TicketController::class);
        Route::apiResource('users', UsersController::class);
        Route::apiResource('authors', AuthorsController::class);
});
