<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlantPestRequest;
use App\Models\PlantPest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PlantPestController extends Controller
{
    public function get($id = null, Request  $request) {
        try {
            if(isset($id)) {
                $plantPest = PlantPest::findOrFail($id);
            } else {
                $plantPest = PlantPest::select('*');
                if(isset($request->plant_id)){
                    $plantPest = $plantPest->where('plant_id', $request->plant_id);
                }
                $plantPest = $plantPest->get();
            }
            return response()->json(['status' => true, 'message' => 'data retrived', 'data' => $plantPest], 200);
        } catch (Exception $e) {
            Log::error('Error get plant pest : '. $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function store(PlantPestRequest  $request) {
        try {

            DB::beginTransaction();

            $filenameImg = time().'.'.$request->img->extension();
            $request->file('img')->move(public_path('media/image'), $filenameImg);

            PlantPest::create([
                'name' => $request->name,
                'img' => asset("media/image/".$filenameImg.""),
                'desc' => $request->desc
            ]);
            
            DB::commit();
            return response()->json(['status' => true, 'message' => 'data success created'], 201);  

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error store plant pest : '. $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
