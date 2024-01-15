<?php

use App\Http\Controllers\API\PlantController;
use App\Http\Controllers\API\PlantTypeController;
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
});