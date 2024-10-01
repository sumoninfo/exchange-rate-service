<?php

use App\Models\User;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::controller(CurrencyController::class)->group(function () {
        Route::get('currencies', 'index');
        Route::get('currencies/{currency}', 'show');
        Route::get('currencies/{id}/history', 'history');
    });
});
