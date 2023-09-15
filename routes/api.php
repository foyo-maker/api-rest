<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonalizedWorkoutController;

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

Route::post('/emailReset', [AuthController::class, 'authenticateEmail']);
Route::patch('/resetPassword', [AuthController::class, 'resetPassword']);
Route::post('/register', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::apiResource('/users', UserController::class);

Route::patch('/changePassword/{user_id}', [AuthController::class, 'updatePassword']);
Route::get('/personalizedWorkout/{user_id}', [PersonalizedWorkoutController::class, 'show']);

Route::post('/personalizedWorkout', [PersonalizedWorkoutController::class, 'store']);
Route::apiResource('/users', UserController::class);


//event
Route::apiResource('/events', EventController::class);