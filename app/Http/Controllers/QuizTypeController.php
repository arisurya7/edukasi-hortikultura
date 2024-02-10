<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizTypeRequest;
use App\Models\QuizType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuizTypeController extends Controller
{
    public function get($id = null, Request $request) {
        try {

            if(isset($id)) {
                $quizType = QuizType::findOrFail($id);
            } else {
                $quizType = QuizType::select('id', 'name')->get();
            }

            return response()->json(['status' => true, 'message' => 'data retrived', 'data' => $quizType], 200);
        }catch (Exception $e) {
            Log::error('Error get quiz type: '. $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function store(QuizTypeRequest $request) {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            QuizType::create(['name' => $data['name']]);
            
            DB::commit();
            return response()->json(['status' => true, 'message' => 'data created'], 201);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error store quiz type: '.$e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
