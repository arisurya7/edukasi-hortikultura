<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Models\PlantPest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PlantPestController extends Controller
{
    //
    public function index(){
        return view("admin.plant-pest.index");
    }

    public function show($id) {
        $data = PlantPest::find($id);
        $plants = Plant::select("id", "name")->get()->toArray();
        return view("admin.plant-pest.form", compact('data', 'plants'));
    }

    public function create() {
        $plants = Plant::select("*")->get();
        return view("admin.plant-pest.form", compact("plants"));
    }

    public function store(Request $request) {
        try {
            $newRequest = new Request();
            $newRequest->header('static_key_api', env('STATIC_KEY_API', ''));
            
            $newRequest->merge([
                'name' => $request->name,
                'img' => $request->file("img"),
                'desc' => $request->desc,
                'plant_id' => $request->plant_id
            ]);
    
            $response = app('App\Http\Controllers\API\PlantPestController')->store($newRequest);
            $content = $response->getContent();
            $data = json_decode($content, true);
            if($data['status']){
                return response()->json(['status' =>  true, "message" => $data["message"]], 200);
            } else {
                throw new Exception($data["message"]);
            }
        } catch (\Exception $e){
            return response()->json(['status' => false, "message" => $e->getMessage()], 400);
        }
    }

    public function edit($id) {
        $data = PlantPest::findOrFail($id);
        $plants = Plant::select("*")->get();
        return view("admin.plant-pest.form", compact('data', 'plants'));
    }

    public function update($id, Request $request) {
        try{
            DB::beginTransaction();
            $dataPlantPest = PlantPest::find($id);
            $input = $request->all();
            
            if($request->file('img')){
                $image = time().'.'.$request->img->extension();
                $request->file('img')->move(public_path('media/image'), $image);
                $input['img'] = $image;
            }else{
                $input['img'] = $dataPlantPest->img;
            }

            $dataPlantPest->update([
                'name' => $request->name,
                'plant_id' => $request->plant_id,
                'desc' => $request->desc,
                'img' => asset("media/image/".$input['img']."")
            ]);
            
            DB::commit();
            return response()->json(['status' =>  true, 'message' => "Berhasil mengupdate data"], 200);
        }catch(Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function destroy($id) {
        try {
            DB::beginTransaction();
            $data = PlantPest::find($id);
            $data->delete();
            DB::commit();
            return response()->json(['status' => true, 'message' => "Berhasil menghapus data"], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function getData(){
        $data = PlantPest::select("id", "name")->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn =  $btn = '<a href="' . route('plant-pest.show', ['plant_pest' => $row->id]) . '"class="btn btn-info btn-sm action-detail" style="margin-left: 5px">View</a>';
                $btn = $btn . '<a href="' . route('plant-pest.edit', ['plant_pest' => $row->id]) . '"class="btn btn-primary btn-sm action-edit" style="margin-left: 5px">Edit</a>';
                $btn = $btn . '<a type="button" onclick="deletePlantPest(`' . $row->id . '`)" class="btn btn-outline-primary btn-sm action-delete" data-url="{{route("plant-disease.destroy")}}" style="margin-left: 5px">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
