<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;
use App\Models\Videos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VideoController extends Controller
{
    public function get($id = null, Request $request){
        try {
            if(isset($id)) {
                $video = Videos::findOrFail($id);
            } else {
                $video = Videos::select('id', 'title', 'link', 'video_id')->get();
            }
            return response()->json(['status'=> true, 'message' => 'data retrived', 'data' => $video], 200);     
        }catch (Exception $e) {
            Log::error('Error get video: '. $e->getMessage());
            return response()->json(['status'=>false, 'message'=>$e->getMessage()], 400);
        }
    }

    public function store(VideoRequest $request) {
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
