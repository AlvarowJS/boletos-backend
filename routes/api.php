<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\DayController as Day;
use App\Http\Controllers\Api\V1\AuthController as Auth;
use App\Http\Controllers\Api\V1\EventController as Event;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/v1/login', [Auth::class, 'login']);
Route::post('/register', [Auth::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/v1/days', Day::class);
    Route::apiResource('/v1/event', Event::class);
});
