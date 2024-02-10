<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlantTypeRequest;
use App\Models\PlantType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function store(PlantTypeRequest $request) {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            PlantType::create(['name' => $data['name']]);
            DB::commit();
            return response()->json(['status'=>true, 'message'=>'data stored'], 200);
        }catch(\Exception $e) {
            DB::rollBack();
            Log::error('Error get store plant type :' . $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }
}