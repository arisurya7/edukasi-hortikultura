<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizRequest;
use App\Models\Quiz;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    public function get($id = null, Request $request) {
        try {
            if(isset($id)) {
                $quiz = Quiz::findOrFail($id);
            } else {
                if (isset($request->quiz_type_id)) {
                    $quiz = Quiz::select('id', 'question', 'answer')->where('quiz_type_id', $request->quiz_type_id)->get();
                } else {
                    $quiz = Quiz::select('id', 'question', 'answer')->get();
                }
            }
            return response()->json(['status' => true, 'message' => 'data retrived', 'data' => $quiz], 200);
        } catch (Exception $e) {
            Log::error('Error get quiz: '. $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function store(QuizRequest $request) {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            Quiz::create([
                'quiz_type_id' => $data['quiz_type_id'],
                'question' => $data['question'],
                'answer' => $data['answer']
            ]);
            DB::commit();
            return response()->json(['status' => true, 'message' => 'data created'], 201);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error store quiz: '. $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function grade(Request $request) {
        try {
            
            $quizTypeId = $request->quiz_type_id;
            $answers = $request->answers;

            $questionTypes = Quiz::select('id', 'answer')->where('quiz_type_id', $quizTypeId)->get();
            $correct = 0;
            $wrong = 0;
            $countQuestion  = count($questionTypes);
            foreach($questionTypes as $k => $item) {
                if(isset($answers[$item->id])) {
                    if($answers[$item->id] == $item->answer) 
                        $correct++;
                    else
                        $wrong++;
                }else {
                    $wrong++;
                }
            } 
            $grade = round(($correct / $countQuestion) * 100, 2);
            return response()->json([
                'status' => true,
                'message' => 'data retrived',
                'data' => [
                        'grade' => $grade,
                        'correct' => $correct,
                        'wrong' => $wrong
                    ]
                ]);
        } catch (Exception $e) {
            Log::error('Error calculate grade: '. $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}
