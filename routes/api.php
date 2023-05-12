<?php

use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResource('rooms', RoomController::class);
Route::apiResource('cars', CarController::class);
Route::apiResource('teams', TeamController::class);
Route::apiResource('reservation', ReservationController::class);

//Route::post('/auth/register', [AuthController::class, 'registerUser']);
