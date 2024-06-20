<?php

use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/events/{id}/check-in/{ticketId}', [EventController::class, 'checkIn'])->name('events.checkIn');
Route::post('/events/{id}', [EventController::class, 'show']);
Route::get('/events/{id}', [EventController::class, 'show']);
Route::get('/events', [EventController::class, 'index']);
Route::get('/subscriptions/{id}', [SubscriptionController::class, 'show']);
