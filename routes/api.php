<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GroupController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login'])->name('api.auth.login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('api.auth.logout');
    Route::get('/auth/me', [AuthController::class, 'me'])->name('api.auth.me');

    Route::apiResource('groups', GroupController::class)->middleware([
        'index' => 'abilities:group.view',
        'show' => 'abilities:group.view',
        'store' => 'abilities:group.create',
        'update' => 'abilities:group.update',
        'destroy' => 'abilities:group.delete',
    ]);
});
