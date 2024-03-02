<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Models\PlantTips;
use App\Models\Videos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class PlantVideoController extends Controller
{
    public function index() {
        return view("admin.video.index"); 
    }

    public function create() {
        return view("admin.video.form"); 
    }

    public function show($id) {
        $data = Videos::find($id);
        return view("admin.video.form", compact('data')); 
    }

    public function store(Request $request) {
        try {
            DB::beginTransaction();

            $videoId = $this->getYouTubeVideoId($request->link);
            if(!$videoId){
                throw new Exception('Invalid Youtube URL');
            }

            Videos::create([
                'title' => $request->title,
                'link' => $request->link,
                'video_id' => $videoId
            ]);

            DB::commit();
            return response()->json(['status' => true, 'message'=> 'data created'], 201);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error store video: '. $e->getMessage());
            return response()->json(['status' =>  false, 'message' => $e->getMessage()], 400);
        }
    }

    public function edit($id) {
        $data = Videos::findOrFail($id);
        return view("admin.video.form", compact('data'));
    }

    public function update($id, Request $request) {
        try {
            DB::beginTransaction();
            $dataVideo = Videos::findOrFail($id);
            $input = $request->all();
            $videoId = $this->getYouTubeVideoId($request->link);
            if(!$videoId){
                throw new Exception('Invalid Youtube URL');
            }

            // dd($request->title, $videoId,  $request->desc, $request->all());
            $dataVideo->update([
                'title' => $request->title,
                'video_id' => $videoId,
                'link' => $request->link
            ]);
            
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Berhasil memperbarui data'], 200);
        } catch(Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function destroy($id) {
        try {
            DB::beginTransaction();
            $data = Videos::find($id);
            $data->delete();
            DB::commit();
            return response()->json(['status' => true, 'message' => "Berhasil menghapus data"], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function getData() {
        $data = Videos::select("id", "title")->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn =  $btn = '<a href="' . route('video.show', ['video' => $row->id]) . '"class="btn btn-info btn-sm action-detail" style="margin-left: 5px">View</a>';
                $btn = $btn . '<a href="' . route('video.edit', ['video' => $row->id]) . '"class="btn btn-primary btn-sm action-edit" style="margin-left: 5px">Edit</a>';
                $btn = $btn . '<a type="button" onclick="deletePlantVideo(`' . $row->id . '`)" class="btn btn-outline-primary btn-sm action-delete" data-url="{{route("video.destroy")}}" style="margin-left: 5px">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getYouTubeVideoId($url) {
        // Match the video ID in a YouTube URL
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/';
        
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1]; // The video ID is captured in group 1
        } else {
            return false; // Invalid YouTube URL
        }
    }

}
