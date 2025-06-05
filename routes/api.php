<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\RewardController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('webhook/log', [WebhookController::class, 'store']);
Route::get('/rewards', [RewardController::class, 'apiIndex']);