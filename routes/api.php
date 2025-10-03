<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\MunicipalityController;
use App\Http\Controllers\Api\StateController;
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

    Route::apiResource('states', StateController::class)->middleware([
        'index' => 'abilities:state.view',
        'show' => 'abilities:state.view',
        'store' => 'abilities:state.create',
        'update' => 'abilities:state.update',
        'destroy' => 'abilities:state.delete',
    ]);

    Route::apiResource('municipalities', MunicipalityController::class)->middleware([
        'index' => 'abilities:municipality.view',
        'show' => 'abilities:municipality.view',
        'store' => 'abilities:municipality.create',
        'update' => 'abilities:municipality.update',
        'destroy' => 'abilities:municipality.delete',
    ]);

    Route::apiResource('companies', CompanyController::class)->middleware([
        'index' => 'abilities:company.view',
        'show' => 'abilities:company.view',
        'store' => 'abilities:company.create',
        'update' => 'abilities:company.update',
        'destroy' => 'abilities:company.delete',
    ]);

    Route::apiResource('customers', CustomerController::class)->middleware([
        'index' => 'abilities:customer.view',
        'show' => 'abilities:customer.view',
        'store' => 'abilities:customer.create',
        'update' => 'abilities:customer.update',
        'destroy' => 'abilities:customer.delete',
    ]);
});
