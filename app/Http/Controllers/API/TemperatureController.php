<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TemperatureController extends Controller
{
    public function get(Request $request){
        try {
            $data = Plant::select(
                'bellow_temperature', 
                'top_temperature', 
                DB::raw('GROUP_CONCAT(name) as plants'))
            ->groupBy('bellow_temperature', 'top_temperature')
            ->get();

            return response()->json(['status' => true, 'message' => 'data retrived', 'data' => $data]);
        
        } catch (Exception $e) {
            Log::error('Error get temperature : ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
