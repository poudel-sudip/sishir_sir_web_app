<?php

namespace App\Http\Controllers\student\Exams;

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

        $writtenexams = $batch->writtenExams->map(function($exam) {
            $result = WrittenExamSolution::where([
                ['user_id','=',auth()->user()->id],
                ['exam_id','=',$exam->id]
            ])->first() ? true: false;

            return (object)[
                'exam'=>$exam,
                'status'=>$result,
            ];
        });

        // dd($batch,$mcqexams,$writtenexams);

        return view('student.Exams.myexams',compact('batch','mcqexams','writtenexams'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $bookings=auth()->user()->bookings()->where('status','=','Verified')->get('batch_id')->toArray();
    //     $batches=[];
    //     foreach ($bookings as $booking) {
    //         $batches[]= $booking['batch_id'];
    //     }
    //     $batches=array_unique($batches);
    //     $mcqexams=BatchExam::whereIn('batch_id',$batches)->get()
    //     ->map(function($myexam){
    //         $exam=Exam::where('id','=',$myexam->exam_id)->first();
    //         $batch=Batch::where('id','=',$myexam->batch_id)->first();
    //         $result=Result::where([
    //             ['user_id','=',auth()->user()->id],
    //             ['exam_id','=',$exam->id],
    //             ['batch_id','=',$batch->id]
    //             ])->first();
    //         $status=false;
    //         if($result)
    //         {
    //             $status=true;
    //         }
    //         return (object)[
    //             'exam'=>$exam,
    //             'batch'=>$batch,
    //             'result'=>$result,
    //             'status'=>$status,
    //         ];
    //     });

    //     $writtenexams=WrittenExam::whereIn('batch_id',$batches)->get()
    //     ->map(function($exam) {
    //         $result=WrittenExamSolution::where([
    //             ['user_id','=',auth()->user()->id],
    //             ['exam_id','=',$exam->id]
    //         ])->first();
    //         $status=false;
    //         if($result)
    //         {
    //             $status=true;
    //         }
    //         return (object)[
    //             'question'=>$exam,
    //             'batch'=>$exam->batch,
    //             'results'=>$result,
    //             'status'=>$status,
    //         ];

    //     });
        
    //     dd($bookings,$batches);
    //     return view('student.Exams.myexams',compact('mcqexams','writtenexams'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

                // if($question->opt_correct=="A")
                // {
                //     $correct_answer=$question->opt_a;
                // }
                // elseif($question->opt_correct=="B")
                // {
                //     $correct_answer=$question->opt_b;
                // }
                // elseif($question->opt_correct=="C")
                // {
                //     $correct_answer=$question->opt_c;
                // }
                // elseif($question->opt_correct=="D")
                // {
                //     $correct_answer=$question->opt_d;
                // }

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        // dd($evaluations->first()->question);
        return view('student.Exams.showresult',[
            'result'=>$result,
            'answers'=>$evaluations,
            'batch'=>$batch,
            'exam'=>$exam,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function takeExam(Batch $batch, Exam $exam)
    {
        return view('student.Exams.takeexam',compact('batch','exam'));
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
