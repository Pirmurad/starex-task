<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PackageController;
use Illuminate\Support\Facades\Route;


Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::apiResource('/packages', PackageController::class)->only('store')->middleware('auth:sanctum');
