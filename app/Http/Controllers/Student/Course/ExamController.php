<?php

namespace App\Http\Controllers\Student\Course;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exams\BatchExam;
use App\Models\Exams\Exam;
use App\Models\Exams\Result;
use App\Models\Exams\Question;
use App\Models\Exams\Evaluation;
use App\Models\Exams\WrittenExam;
use App\Models\Batch;
use App\Models\Exams\WrittenExamSolution;
use Illuminate\Support\Facades\Gate;

class ExamController extends Controller
{


    public function index(Batch $batch)
    {
        Gate::authorize('classroom',$batch);

        $data = [];
        $data['batch'] = $batch;

        $mcqexams = $batch->batchExams->map(function($exam) use($batch) {
            $exam = $exam->exam;
            $result = Result::where([
                ['user_id','=',auth()->user()->id],
                ['exam_id','=',$exam->id],
                ['batch_id','=',$batch->id]
            ])->first() ? true : false ;

            return (object)[
                'exam'=>$exam,
                'status'=>$result,
            ];
        });

        $data['mcqexams'] = $mcqexams;
        

        // dd($batch,$mcqexams);

        return view('student.courses.exams.myexams',$data);
    }


    public function store(Request $request, Batch $batch, Exam $exam)
    {
        // dd($request->all());
        $user=auth()->user();
        $total_questions=$request->index;
        $leaved_questions=0;
        $correct_questions=0;
        $wrong_questions=0;
        $data=$request->all();
        for ($i=1; $i <= $total_questions; $i++) { 
            if(isset($data['question-'.$i]))
            {                  
                $question=Question::where('id',$data['question-'.$i])->first();
                $correct_answer=$question->opt_correct;
                $my_answer="";

                if(isset($data['ans-'.$i])){
                    $ans=explode("=>",$data['ans-'.$i]);
                    if($question->opt_correct==$ans[0])
                    {
                        $correct_questions++;
                    }else{
                        $wrong_questions++;
                    }
                    $my_answer=$ans[0];
                }else{
                    $leaved_questions++;
                }
                
                Evaluation::create([
                    'user_id'=>$user->id,
                    'batch_id'=>$batch->id,
                    'exam_id'=>$exam->id,
                    'question_id'=>$question->id,
                    'correct_ans'=>$correct_answer,
                    'your_ans'=>$my_answer,
                ]);

            }

        }
        Result::create([
            'user_id'=>$user->id,
            'batch_id'=>$batch->id,
            'exam_id'=>$exam->id,
            'total_questions'=>$total_questions,
            'leaved_questions'=>$leaved_questions,
            'correct_questions'=>$correct_questions,
            'wrong_questions'=>$wrong_questions,
        ]);

        return redirect('/student/classroom/exams/'.$batch->id);
    }


    public function show(Batch $batch,Exam $exam)
    {
        $user=auth()->user();
        $result=Result::where([
            ['user_id','=',$user->id],
            ['batch_id','=',$batch->id],
            ['exam_id','=',$exam->id],
        ])->first();

        $evaluations=Evaluation::where([
            ['user_id','=',$user->id],
            ['batch_id','=',$batch->id],
            ['exam_id','=',$exam->id],
        ])->get();
        $data = [];
        $data['result'] = $result;
        $data['answers'] = $evaluations;
        $data['batch'] = $batch;
        $data['exam'] = $exam;
        
        // dd($evaluations->first()->question);
        return view('student.courses.exams.showresult',$data);
    }

 
    public function takeExam(Batch $batch, Exam $exam)
    {
        return view('student.courses.exams.takeexam',compact('batch','exam'));
    }

    public function reset(Batch $batch,Exam $exam)
    {
        // dd($batch,$exam);
        $user=auth()->user();
        $result=Result::where([
            ['user_id','=',$user->id],
            ['batch_id','=',$batch->id],
            ['exam_id','=',$exam->id],
        ])->delete();

        $evaluations=Evaluation::where([
            ['user_id','=',$user->id],
            ['batch_id','=',$batch->id],
            ['exam_id','=',$exam->id],
        ])->delete();
        // dd($result,$evaluations);
        return redirect('/student/classroom/exams/'.$batch->id);
    }
}
