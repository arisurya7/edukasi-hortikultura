<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Models\PlantType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PlantController extends Controller
{
    public function index(Request $request) {
        // $plant = Plant::select('id', 'name')->get();
        return view("admin.plant.index");
    }

    public function show($id){
        $data = Plant::find($id);
        $plantType = PlantType::select("id", "name")->get()->toArray();
        return view("admin.plant.form", compact('data', 'plantType'));
    }

    public function create() {
        $plantType = PlantType::select("id", "name")->get();
        return view("admin.plant.form", compact("plantType"));
    }


    public function store(Request $request) {
        try {
            $newRequest = new Request();
            $newRequest->header('static_key_api', env('STATIC_KEY_API', ''));
            
            $newRequest->merge([
                'name' => $request->name,
                'plant_type_id' => $request->plant_type_id,
                'bellow_temperature' => $request->bellow_temperature,
                'top_temperature' => $request->top_temperature,
                'img' => $request->file("img"),
                'desc' => $request->desc,
            ]);
            
            $response = app('App\Http\Controllers\API\PlantController')->store($newRequest);
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
        $data = Plant::find($id);
        $plantType = PlantType::select("id", "name")->get()->toArray();
        return view("admin.plant.form", compact('data', 'plantType'));
    }

    public function update($id, Request $request) {
        try {
            DB::beginTransaction();
            $dataPlant = Plant::findOrFail($id);
            $input = $request->all();
            
            if($request->file('img')){
                $image = time().'.'.$request->img->extension();
                $request->file('img')->move(public_path('media/image'), $image);
                $input['img'] = $image;
            }else{
                $input['img'] = $dataPlant->img;
            }

            $dataPlant->update([
                'name' => $request->name,
                'plant_type_id' => $request->plant_type_id,
                'bellow_temperature' => $request->bellow_temperature,
                'top_temperature' => $request->top_temperature,
                'desc' => $request->desc,
                'img' => asset("media/image/".$input['img']."")
            ]);
            
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Berhasil memperbarui data'], 200);
        } catch(Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Berhasil memperbarui data'], 400);
        }
    }

    public function destroy($id) {
        try {
            DB::beginTransaction();
            $data = Plant::find($id);
            $data->delete();
            DB::commit();
            return response()->json(['status' => true, 'message' => "Berhasil menghapus data"], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function getData(){
        $data = Plant::select("id", "name")->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn =  $btn = '<a href="' . route('plant.show', ['plant' => $row->id]) . '"class="btn btn-info btn-sm action-detail" style="margin-left: 5px">View</a>';
                $btn = $btn . '<a href="' . route('plant.edit', ['plant' => $row->id]) . '"class="btn btn-primary btn-sm action-edit" style="margin-left: 5px">Edit</a>';
                $btn = $btn . '<a type="button" onclick="deletePlant(`' . $row->id . '`)" class="btn btn-outline-primary btn-sm action-delete" data-url="{{route("plant.destroy")}}" style="margin-left: 5px">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
