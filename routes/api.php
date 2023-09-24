<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\SymptomController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\DiseaseSymptomController;
use App\Http\Controllers\DiseaseRecipeController;
use App\Http\Controllers\DiseaseHospitalController;
use App\Http\Controllers\HospitalController;
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

Route::apiResource('/symptoms', SymptomController::class);
Route::apiResource('/diseases', DiseaseController::class);
Route::apiResource('/recipes', RecipeController::class);
Route::apiResource('/hospitals', HospitalController::class);
// Route::get('/diseaseSymptom', [DiseaseSymptomController::class,'index']);
// Route::post('/diseaseSymptoms', [DiseaseSymptomController::class,'store']);
Route::get('/matchedDiseaseSymptom/{disease_id}', [DiseaseSymptomController::class,'showDiseaseSymptom']);
Route::get('/matchedSymptomDisease/{symptom_id}', [DiseaseSymptomController::class,'showSymptomDisease']);
Route::get('/matchedDiseaseHospital/{disease_id}', [DiseaseHospitalController::class,'showDiseaseHospital']);
Route::get('/matchedDiseaseRecipe/{disease_id}', [DiseaseRecipeController::class,'showDiseaseRecipe']);
Route::apiResource('/diseaseSymptom', DiseaseSymptomController::class);
Route::apiResource('/diseaseRecipe', DiseaseRecipeController::class);
Route::apiResource('/diseaseHospital', DiseaseHospitalController::class);
Route::patch('/changePassword/{user_id}', [AuthController::class, 'updatePassword']);


Route::patch('/rating/{user_id}', [AuthController::class, 'updateRate']);
Route::get('/personalizedWorkout/{user_id}', [PersonalizedWorkoutController::class, 'show']);
Route::get('/admins', [UserController::class, 'showAdmin']);
Route::post('/admins', [UserController::class, 'storeAdmin']);
Route::post('/personalizedWorkout', [PersonalizedWorkoutController::class, 'store']);
Route::apiResource('/users', UserController::class);


//event
Route::apiResource('/events', EventController::class);