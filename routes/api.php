<?php

use App\Http\Controllers\API\PlantController;
use App\Http\Controllers\API\PlantDiseaseController;
use App\Http\Controllers\API\PlantPestController;
use App\Http\Controllers\API\PlantTypeController;
use App\Http\Controllers\API\TemperatureController;
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
    Route::get('plant-desease/{id}', [PlantDiseaseController::class, 'get']);
    Route::post('plant-desease', [PlantDiseaseController::class, 'store']);

    //plant pest
    Route::get('plant-pests', [PlantPestController::class, 'get']);
    Route::get('plant-pest/{id}', [PlantPestController::class, 'get']);
    Route::post('plant-pest', [PlantPestController::class, 'store']);
});