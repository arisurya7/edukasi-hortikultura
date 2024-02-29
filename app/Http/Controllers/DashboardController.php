<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Models\PlantDisease;
use App\Models\PlantPest;
use App\Models\PlantTips;
use App\Models\Videos;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $countPlant = Plant::count();
        $countPlantDisease = PlantDisease::count();
        $countPlantPest = PlantPest::count();
        $countPlantTips = PlantTips::count();
        $countVideo = Videos::count();

        return view("admin.dashboard.index", compact("countPlant", "countPlantDisease", "countPlantPest", "countPlantTips", "countVideo"));
    }
}
