<?php

use App\Http\Controllers\API\PlantController;
use App\Http\Controllers\API\PlantDiseaseController;
use App\Http\Controllers\API\PlantPestController;
use App\Http\Controllers\API\PlantTypeController;
use App\Http\Controllers\API\TemperatureController;
use App\Http\Controllers\PlantTipsController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizTypeController;
use App\Models\QuizType;
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

Route::middleware('staticKey')->group(function() {
    Route::get('plant-type', [PlantTypeController::class, 'get']);
    Route::get('plants', [PlantController::class, 'get']);
    Route::get('plant/{id}', [PlantController::class, 'get']);
    Route::post('plant', [PlantController::class, 'store']);
    Route::get('temperatures', [TemperatureController::class, 'get']);
    
    //plant disease
    Route::get('plant-diseases', [PlantDiseaseController::class, 'get']);
    Route::get('plant-disease/{id}', [PlantDiseaseController::class, 'get']);
    Route::post('plant-disease', [PlantDiseaseController::class, 'store']);

    //plant pest
    Route::get('plant-pests', [PlantPestController::class, 'get']);
    Route::get('plant-pest/{id}', [PlantPestController::class, 'get']);
    Route::post('plant-pest', [PlantPestController::class, 'store']);
    
    //plant tips
    Route::get('plant-tipss', [PlantTipsController::class, 'get']);
    Route::get('plant-tips/{id}', [PlantTipsController::class, 'get']);
    Route::post('plant-tips', [PlantTipsController::class, 'store']);

    //quiz type
    Route::get('quiz-types', [QuizTypeController::class, 'get']);
    Route::get('quiz-type/{id}', [QuizTypeController::class, 'get']);
    Route::post('quiz-type', [QuizTypeController::class, 'store']);

    //quiz
    Route::get('quizzes', [QuizController::class, 'get']);
    Route::post('quiz', [QuizController::class, 'store']);
    Route::post('quiz-grade', [QuizController::class, 'grade']);
});