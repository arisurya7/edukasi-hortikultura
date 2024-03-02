<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class QuizTypeController extends Controller
{
    public function index() {
        return view("admin.quiz-type.index"); 
    }

    public function create() {
        return view("admin.quiz-type.form"); 
    }

    public function show($id) {
        $data = QuizType::find($id);
        return view("admin.quiz-type.form", compact('data')); 
    }

    public function store(Request $request) {
        try {
            DB::beginTransaction();

            QuizType::create(['name' => $request->name]);

            DB::commit();
            return response()->json(['status' => true, 'message'=> 'data created'], 201);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error store video: '. $e->getMessage());
            return response()->json(['status' =>  false, 'message' => $e->getMessage()], 400);
        }
    }

    public function edit($id) { 
        $data = QuizType::findOrFail($id);
        return view("admin.quiz-type.form", compact('data'));
    }

    public function update($id, Request $request) {
        try {
            DB::beginTransaction();
            $dataQuizType = QuizType::findOrFail($id);
            $dataQuizType->update(['name' => $request->name]);
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
            $data = QuizType::find($id);
            $data->delete();
            DB::commit();
            return response()->json(['status' => true, 'message' => "Berhasil menghapus data"], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function getData() {
        $data = QuizType::select("id", "name")->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = $btn = '<a href="' . route('quiz-type.show', ['quiz_type' => $row->id]) . '"class="btn btn-info btn-sm action-detail" style="margin-left: 5px">View</a>';
                $btn = $btn . '<a href="' . route('quiz-type.edit', ['quiz_type' => $row->id]) . '"class="btn btn-primary btn-sm action-edit" style="margin-left: 5px">Edit</a>';
                $btn = $btn . '<a type="button" onclick="deleteQuizType(`' . $row->id . '`)" class="btn btn-outline-primary btn-sm action-delete" data-url="{{route("quiz_type.destroy")}}" style="margin-left: 5px">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

}
