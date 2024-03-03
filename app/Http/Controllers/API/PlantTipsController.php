<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlantPestRequest;
use App\Http\Requests\PlantTipsRequest;
use App\Models\PlantTips;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PlantTipsController extends Controller
{
    /**
     * fungsi untuk mendapatkan sepesifik data plant tips dan semua data plant tips
     */
    public function get($id = null, Request  $request) {
        try {
            //jika data id nya ada, cari spesifik data plant tips
            if(isset($id)) {
                $plantTips = PlantTips::findOrFail($id);
            } else {
                //ambil semua data plant tips
                $plantTips = PlantTips::get();
            }
            return response()->json(['status' => true, 'message' => 'data retrived', 'data' => $plantTips], 200);
        } catch (Exception $e) {
            Log::error('Error get plant tips : '. $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * fungsi untuk menyimpan data plant tips
     */
    public function store(Request  $request) {
        try {

            DB::beginTransaction();

            $filenameImg = time().'.'.$request->img->extension();
            if($request->file('img') == null && isset($request->img)) {
                $request->img->move(public_path('media/image'), $filenameImg);
            } else {
                $request->file('img')->move(public_path('media/image'), $filenameImg);
            }

            PlantTips::create([
                'name' => $request->name,
                'img' => asset("media/image/".$filenameImg.""),
                'desc' => $request->desc
            ]);
            
            DB::commit();
            return response()->json(['status' => true, 'message' => 'data success created'], 201);  

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error store plant tips : '. $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
