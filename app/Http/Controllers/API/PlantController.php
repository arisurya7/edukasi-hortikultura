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
    /**
     * Fungsi untuk menampilkan data tanaman berdasarkan spesifik tanaman (id),
     * berdasarkan nama atau tipe tanamannya
     * 
     */
    public function get($id = null, Request $request){
        try {
            //Jika parameter id ada, cari spesifik tanaman berdasarkan id nya
            if(isset($id)) {
                $plants = Plant::findOrFail($id);
            } 
            else {
                //Select semua kolom  pada model plant
                $data = Plant::select('*');
                //Jika terdapat paramter name, cari data tanaman yang namanya sama seperti value name
                if(isset($request->name)) {
                    $data = $data->where('name', 'like', '%'.$request->name.'%');
                }
                //Jika terdapat parameter plant_type_id, cari data tanaman yang memiliki tipe tanaman sama dengan plant type id
                if(isset($request->plant_type_id)) {
                    $data = $data->where('plant_type_id', $request->plant_type_id);
                }
                //ambil data tanaman
                $plants = $data->get();
            }
            return response()->json(['status' => true, 'message' => 'data retrived', 'data' => $plants], 200);
        } catch (\Exception $e) {
            Log::error('Error  get plant :' .$e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        } 
    }

    /**
     * Fungsi untuk menghitung jumlah data
     * untuk tanaman, penyakit tanaman, hama tanaman
     * tips, dan video
     * 
     */
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

    /**
     * 
     * Fungsi untuk menyimpan data tanaman 
     * 
     *  */
    public function store(Request $request){
        try {    
            //buat nama file img berdasarkan waktu dengan ekstensi filenya
            $filenameImg = time().'.'.$request->img->extension();
            //jika file img nya sama dengan null, ambil img langsung dari request lalu pindahkan filenya ke public_path('media/image')
            if($request->file('img') == null && $request->img != null){
                $request->img->move(public_path('media/image'), $filenameImg);
            } else {
                $request->file('img')->move(public_path('media/image'), $filenameImg);
            }
            //buat data tanaman dari request yang didapatkan
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
