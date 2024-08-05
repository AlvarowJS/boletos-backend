<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\DayController as Day;
use App\Http\Controllers\Api\V1\AuthController as Auth;
use App\Http\Controllers\Api\V1\EventController as Event;
use App\Http\Controllers\Api\V1\EventDayController as Eventday;
use App\Http\Controllers\Api\V1\TicketController as Ticket;
use App\Http\Controllers\Api\V1\UserController as User;
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
    Route::post('/token-auth', [Auth::class, 'authToken']);
    Route::apiResource('/v1/days', Day::class);
    Route::apiResource('/v1/event', Event::class);
    Route::apiResource('/v1/eventday', Eventday::class);
    Route::apiResource('/v1/ticket', Ticket::class);
    Route::apiResource('/v1/users', User::class);
    Route::post('v1/event-update', [Event::class, 'updateEvent']);
    Route::post('v1/generate-qr', [Ticket::class, 'generateQR']);
    Route::get('v1/ocultar-mostrar/{id}', [Eventday::class, 'ocultarMostrar']);

});
