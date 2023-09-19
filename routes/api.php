<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\SymptomController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\DiseaseRecipeController;
use App\Http\Controllers\HospitalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

Route::post('/register', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::apiResource('/users', UserController::class);
Route::apiResource('/symptoms', SymptomController::class);
Route::get('/diseases', [DiseaseController::class,'index']);//cant apiResource maybe i havent define other crud method in diseasecontroller
Route::get('/recipes', [RecipeController::class,'index']);//cant apiResource maybe i havent define other crud method in recipecontroller
Route::get('/diseaserecipes', [DiseaseRecipeController::class,'index']);//testing only
Route::get('/hospitals', [HospitalController::class,'index']);//cant apiResource maybe i havent define other crud method in recipecontroller
