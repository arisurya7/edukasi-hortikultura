<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlantRequest;
use App\Models\Plant;
use App\Models\PlantDisease;
use App\Models\PlantPest;
use App\Models\PlantTips;
use App\Models\Videos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlantController extends Controller
{
    public function get($id = null, Request $request){
        try {
            if(isset($id)) {
                $plants = Plant::findOrFail($id);
            } else {
                
                if(isset($request->name)) {
                    $data = Plant::where('name', 'like', '%'.$request->name.'%');
                }

                if(isset($request->plant_type_id)) {
                    if (isset($data)) {
                        $data = $data->where('plant_type_id', $request->plant_type_id);
                    }else{
                        $data = Plant::where('plant_type_id', $request->plant_type_id);
                    }
                }
                
                $plants = $data->get();
            }
            return response()->json(['status' => true, 'message' => 'data retrived', 'data' => $plants], 200);
        } catch (\Exception $e) {
            Log::error('Error  get plant :' .$e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        } 
    }

    public function count(){
        try{

            $data = [
                "plant" => Plant::count(),
                "plant_disease" => PlantDisease::count(),
                "plant_pest" => PlantPest::count(),
                "plant_tips" => PlantTips::count(),
                "plant_video" => Videos::count(),
            ];
            
            return response()->json(['status' => true, "message" => "data retrived", "data" => $data], 200);
        }catch(Exception $e){
            return response()->json(['status' =>  false, "message" => $e->getMessage()], 400);
        }
    }

    public function store(PlantRequest $request){
        try {    

            $filenameImg = time().'.'.$request->img->extension();
            $request->file('img')->move(public_path('media/image'), $filenameImg);
           
            Plant::create([
                'plant_type_id' => $request->plant_type_id,
                'name' => $request->name,
                'img' => asset("media/image/".$filenameImg.""),
                'desc' => $request->desc,
                'bellow_temperature' => $request->bellow_temperature,
                'top_temperature' => $request->top_temperature,
            ]);

            return response()->json(['status' => true, 'message' => 'data success created'], 200);
        } catch (\Exception $e) {
            Log::error('Error store plant : '. $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
