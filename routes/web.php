<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\PlantDiseaseController;
use App\Http\Controllers\PlantPestController;
use App\Http\Controllers\PlantTipsController;
use App\Http\Controllers\PlantVideoController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizTypeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('admin/dashboard');
})->middleware(['auth']);

Route::prefix('admin')->middleware(['auth'])->group( function() {
    Route::get("/dashboard", [DashboardController::class, 'index'])->name("dashboard");
    
    Route::resource('/plant', PlantController::class);
    Route::get("/plant-getData", [PlantController::class, 'getData'])->name("getDataPlant");

    Route::resource('/plant-disease', PlantDiseaseController::class);
    Route::get("/plant-disesea-getData", [PlantDiseaseController::class, 'getData'])->name("getDataPlantDisease");

    Route::resource('/plant-pest', PlantPestController::class);
    Route::get("/plant-pest-getData", [PlantPestController::class, 'getData'])->name("getDataPlantPest");

    Route::resource('/plant-tips', PlantTipsController::class);
    Route::get("/plant-tips-getData", [PlantTipsController::class, 'getData'])->name("getDataPlantTips");

    Route::resource('/video', PlantVideoController::class);
    Route::get("/video-getData", [PlantVideoController::class, 'getData'])->name("getDataVideo");

    Route::resource('/quiz-type', QuizTypeController::class);
    Route::get("/quiz-type-getData", [QuizTypeController::class, 'getData'])->name("getDataQuizType");

    Route::resource('/quiz', QuizController::class);
    Route::get("/quiz-getData", [QuizController::class, 'getData'])->name("getDataQuiz");

});

require __DIR__.'/auth.php';