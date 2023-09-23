<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\SymptomController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\DiseaseRecipeController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventParticipantsController;
use App\Http\Controllers\WorkoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonalizedWorkoutController;

use App\Http\Controllers\UserPlanController;
use App\Http\Controllers\UserPlanListController;

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
Route::apiResource('/symptoms', SymptomController::class);
Route::get('/diseases', [DiseaseController::class,'index']);//cant apiResource maybe i havent define other crud method in diseasecontroller
Route::get('/recipes', [RecipeController::class,'index']);//cant apiResource maybe i havent define other crud method in recipecontroller
Route::get('/diseaserecipes', [DiseaseRecipeController::class,'index']);//testing only
Route::get('/hospitals', [HospitalController::class,'index']);//cant apiResource maybe i havent define other crud method in recipecontroller


Route::patch('/changePassword/{user_id}', [AuthController::class, 'updatePassword']);


Route::patch('/rating/{user_id}', [AuthController::class, 'updateRate']);
Route::get('/personalizedWorkout/{user_id}', [PersonalizedWorkoutController::class, 'show']);
Route::get('/admins', [UserController::class, 'showAdmin']);
Route::post('/admins', [UserController::class, 'storeAdmin']);
Route::post('/personalizedWorkout', [PersonalizedWorkoutController::class, 'store']);
Route::apiResource('/users', UserController::class);


//event
Route::apiResource('/events', EventController::class);

//UserPlan
Route::apiResource('/userPlans', UserPlanController::class);
Route::get('/userPlans/{user_id}',[UserPlanController::class, 'show']);
Route::post('/inserUserPlan',[UserPlanController::class, 'store']);
Route::delete('deleteUserPlan/{id}',[UserPlanController::class, 'destroy']);
Route::patch('/userPlans/{id}', [AuthController::class, 'update']);
//userPlanWorkout
Route::get('/userPlanList/{user_plan_id}',[UserPlanListController::class, 'show']);
Route::delete('deleteUserPlanList/{id}', [UserPlanListController::class, 'destroy']);
Route::apiResource('/userPlanList', UserPlanListController::class);

Route::apiResource('/workouts', WorkoutController::class);