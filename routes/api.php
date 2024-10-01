<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrencyController;

Route::get('/fetch-token', function () {
    $user = User::query()->first();
    if (empty($user)) {
        $user = User::factory()->create();
    }
    $token = $user->createToken('token-name')->plainTextToken;

    return response()->json([
        'status' => true,
        'token' => $token,
    ]);
});

Route::middleware('auth:sanctum')->controller(CurrencyController::class)->group(function () {
    Route::get('currencies', 'index');
    Route::get('currencies/{currency}', 'show');
    Route::get('currencies/{id}/history', 'history');
});
