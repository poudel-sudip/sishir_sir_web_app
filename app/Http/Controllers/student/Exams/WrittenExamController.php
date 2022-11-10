<?php

namespace App\Http\Controllers\student\Exams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Exams\WrittenExam;
use App\Models\Exams\WrittenExamSolution;

class WrittenExamController extends Controller
{
   public function solve(Batch $batch, WrittenExam $exam)
   {
        return view('student.Exams.solvequestion',compact('batch','exam'));
   }

   public function save(Request $request, Batch $batch, WrittenExam $exam)
   {
        // dd($request->all(),$batch,$exam);
        $request->validate([
            'answer'=>'required|string'
        ]);
        WrittenExamSolution::create([
            'user_id'=>auth()->user()->id,
            'exam_id'=>$exam->id,
            'answer'=>$request->answer,
        ]);

        return redirect('/student/exams');
   }

   public function view(Batch $batch, WrittenExam $exam)
   {
        $answer=WrittenExamSolution::where([
            ['user_id','=',auth()->user()->id],
            ['exam_id','=',$exam->id],
        ])->first();

        return view('student.Exams.questionsolution',compact('batch','exam','answer'));
   }

}
