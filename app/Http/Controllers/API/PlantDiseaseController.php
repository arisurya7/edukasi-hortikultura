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
    /**
     * Fungsi untuk menampilkan data penyakit tanaman berdasarkan spesifik (id),
     * atau tanamannya*
     *  
     */
    public function get($id = null, Request $request) {
        try {
            //jika parameter id ada, ambil sepesifik data plant disease
            if(isset($id)) {
                $plantDisease = PlantDisease::findOrFail($id);
            } else {
                //select semua kolom
                $plantDisease = PlantDisease::select("*");
                //jika parameter plant id nya ada, query data yang sama plant id dengan data request
                if(isset($request->plant_id)) {
                    $plantDisease = $plantDisease->where("plant_id", $request->plant_id);
                }
                //get data plant disease
                $plantDisease = $plantDisease->get();
            }
            return response()->json(['status' => true, 'message' => 'data retrived', 'data' => $plantDisease], 200);
        } catch (Exception $e) {
            Log::error('Error get plant desease : '. $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Fungsi untuk menyimpan data penyakit tanaman
     */
    public function store(Request $request) {
        try {
            DB::beginTransaction();
            $filenameImg = time().'.'.$request->img->extension();
            if($request->file('img') == null){
                $request->img->move(public_path('media/image'), $filenameImg);
            } else {
                $request->file("img")->move(public_path('media/image'), $filenameImg);
            }

            PlantDisease::create([
                'name' => $request->name,
                'img' => asset("media/image/".$filenameImg.""),
                'desc' => $request->desc,
                'plant_id' => $request->plant_id,
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
