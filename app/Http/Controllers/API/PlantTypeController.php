<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PlantType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlantTypeController extends Controller
{
    public function  get($id = null) {
        try {
            if(isset($id)) {
                $plantTypes = PlantType::findOrFail($id);
            } else {
                $plantTypes = PlantType::select('id', 'name')->get();
            }
            return response()->json(['status' => true, 'data' => $plantTypes, 'message' => 'data retrived']);
        } catch(\Exception $e) {
            Log::error('Error get plant type :' . $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }
}