<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class QuizController extends Controller
{
    public function index() {
        return view("admin.quiz.index");
    }

    public function create() {
        $quizType = QuizType::select('id', 'name')->get();
        return view("admin.quiz.form", compact("quizType")); 
    }

    public function show($id) {
        $data = Quiz::find($id);
        // dd($data);
        $quizType = QuizType::select('id', 'name')->get();
        return view("admin.quiz.form", compact('data', 'quizType')); 
    }

    public function store(Request $request) {
        try {
            DB::beginTransaction();

            Quiz::create([
                'quiz_type_id' => $request->quiz_type_id,
                'question' => $request->question,
                'answer' => $request->answer,
            ]);
            DB::commit();
            return response()->json(['status' => true, 'message'=> 'data created'], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' =>  false, 'message' => $e->getMessage()], 400);
        }
    }

    public function edit($id) { 
        $data = Quiz::findOrFail($id);
        $quizType = QuizType::select('id', 'name')->get();
        return view("admin.quiz.form", compact('data', 'quizType'));
    }

    public function update($id, Request $request) {
        try {
            DB::beginTransaction();
            $dataQuiz = Quiz::findOrFail($id);
            $dataQuiz->update([
                'quiz_type_id' => $request->quiz_type_id,
                'question' => $request->question,
                'answer' => $request->answer,
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
            $data = Quiz::find($id);
            $data->delete();
            DB::commit();
            return response()->json(['status' => true, 'message' => "Berhasil menghapus data"], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function getData() {
        $data = Quiz::select("m_quiz.id", "m_quiz.question", DB::raw("m_quiz_type.name AS quiz_type_name"))
            ->leftJoin("m_quiz_type", "m_quiz_type.id", "=", "m_quiz.quiz_type_id")
            ->get();
        // dd($data);  
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = $btn = '<a href="' . route('quiz.show', ['quiz' => $row->id]) . '"class="btn btn-info btn-sm action-detail" style="margin-left: 5px">View</a>';
                $btn = $btn . '<a href="' . route('quiz.edit', ['quiz' => $row->id]) . '"class="btn btn-primary btn-sm action-edit" style="margin-left: 5px">Edit</a>';
                $btn = $btn . '<a type="button" onclick="deleteQuiz(`' . $row->id . '`)" class="btn btn-outline-primary btn-sm action-delete" data-url="{{route("quiz.destroy")}}" style="margin-left: 5px">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
