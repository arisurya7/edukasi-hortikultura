<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlantDiseaseRequest;
use App\Models\PlantDisease;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PlantDiseaseController extends Controller
{
    public function get($id = null, Request $request) {
        try {
            if(isset($id)) {
                $plantDisease = PlantDisease::findOrFail($id);
            } else {
                $plantDisease = PlantDisease::get();
            }
            return response()->json(['status' => true, 'message' => 'data retrived', 'data' => $plantDisease], 200);
        } catch (Exception $e) {
            Log::error('Error get plant desease : '. $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function store(PlantDiseaseRequest $request) {
        try {
            DB::beginTransaction();
            $filenameImg = time().'.'.$request->img->extension();
            $request->file('img')->move(public_path('media/public'), $filenameImg);

            PlantDisease::create([
                'name' => $request->name,
                'img' => asset("media/image/".$filenameImg.""),
                'desc' => $request->desc
            ]);
            DB::commit();
            return response()->json(['status' => true, 'message' => 'data success created'], 201);   
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error store plant desease : ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }

    }
}
