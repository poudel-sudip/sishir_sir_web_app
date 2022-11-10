<?php

namespace App\Http\Controllers\APIs\Student\MainCourse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Batch;
use App\Models\Exams\BatchExam;
use App\Models\Exams\Exam;
use App\Models\Exams\Result;
use App\Models\Exams\Question;
use App\Models\Exams\Evaluation;

class MCQExamController extends Controller
{
    protected $user; 

    protected function guard()
    {
        return Auth::guard('api');
    }

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->user=$this->guard()->user();
    }

    public function index($batchID)
    {
        $batch = Batch::find($batchID);
        if(!$batch)
        {
            return response()->json(['error'=>'Course Batch Not Found'], 404);
        }

        $mcqexams = $batch->batchExams->map(function($exam) use($batch) {
            $exam = $exam->exam;
            $result = Result::where([
                ['user_id','=',auth()->user()->id],
                ['exam_id','=',$exam->id],
                ['batch_id','=',$batch->id]
            ])->first() ? true : false ;

            return (object)[
                'is_solved' => $result,
                'batch_id' => $batch->id,
                'batch_name' => $batch->name,
                'batch_slug' => $batch->slug,
                'batch_status' => $batch->status,
                'class_status' => $batch->class_status,
                'exam_id' => $exam->id,
                'exam_name' => $exam->name,
                'attempt_link' => url('api/v1/my/course/classroom/'.$batch->id.'/mcq-exams/'.$exam->id.'/attempt'),
                'evaluation_link' => url('api/v1/my/course/classroom/'.$batch->id.'/mcq-exams/'.$exam->id.'/view'),
                'reset_link' => url('api/v1/my/course/classroom/'.$batch->id.'/mcq-exams/'.$exam->id.'/reset'),
            ];
        });

        return $mcqexams;
    }

    // public function index()
    // {
    //     $bookings=$this->user->bookings()->where('status','=','Verified')->get('batch_id')->toArray();
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
    //             'is_solved' => $status,
    //             'batch_id' => $batch->id,
    //             'batch_name' => $batch->name,
    //             'batch_slug' => $batch->slug,
    //             'exam_id' => $exam->id,
    //             'exam_name' => $exam->name,
    //             'attempt_link' => url('api/v1/my/course/classroom/'.$batch->id.'/mcq-exams/'.$exam->id.'/attempt'),
    //             'evaluation_link' => url('api/v1/my/course/classroom/'.$batch->id.'/mcq-exams/'.$exam->id.'/view'),
    //             'reset_link' => url('api/v1/my/course/classroom/'.$batch->id.'/mcq-exams/'.$exam->id.'/reset'),
    //         ];
    //     });

    //     return $mcqexams;
    // }

    public function attempt($batchID,$examID)
    {
        $batch = Batch::find($batchID);
        if(!$batch)
        {
            return response()->json(['error'=>'Course Batch Not Found'], 404);
        }

        $exam = Exam::find($examID);
        if(!$exam)
        {
            return response()->json(['error'=>'Exam Not Found'], 404);
        }
        
        return response()->json([
            'batch_id' => $batch->id,
            'batch_name' => $batch->name,
            'batch_slug' => $batch->slug,
            'batch_status' => $batch->status,
            'class_status' => $batch->class_status,
            'exam_id' => $exam->id,
            'exam_name' => $exam->name,
            'exam_description' => $exam->description,
            'exam_time' => $exam->exam_time.':00',
            'marks_per_question' => $exam->marks_per_question,
            'negative_marks_per_question' => $exam->negative_marks,
            'form_post_link' => url('api/v1/my/course/classroom/'.$batch->id.'/mcq-exams/'.$exam->id.'/save'),
            'total_questions' => $exam->questions->count(),
            'questions' => $exam->questions->map(function($question){
                return [
                    'id'=> $question->id,
                    'question' => $question->name,
                    'option_a' => $question->opt_a,
                    'option_b' => $question->opt_b,
                    'option_c' => $question->opt_c,
                    'option_d' => $question->opt_d,
                ];
            }),
        ], 200);
    }

    public function reset($batchID,$examID)
    {
        $batch = Batch::find($batchID);
        if(!$batch)
        {
            return response()->json(['error'=>'Course Batch Not Found'], 404);
        }

        $exam = Exam::find($examID);
        if(!$exam)
        {
            return response()->json(['error'=>'Exam Not Found'], 404);
        }

        $result=Result::where([
            ['user_id','=',$this->user->id],
            ['batch_id','=',$batch->id],
            ['exam_id','=',$exam->id],
        ])->delete();

        $evaluations=Evaluation::where([
            ['user_id','=',$this->user->id],
            ['batch_id','=',$batch->id],
            ['exam_id','=',$exam->id],
        ])->delete();

        return response()->json([
            'success' => 'The Exam Solution Has Been Reset.',
        ], 200);
    }

    public function view($batchID,$examID)
    {
        $batch = Batch::find($batchID);
        if(!$batch)
        {
            return response()->json(['error'=>'Course Batch Not Found'], 404);
        }

        $exam = Exam::find($examID);
        if(!$exam)
        {
            return response()->json(['error'=>'Exam Not Found'], 404);
        }

        $result=Result::where([
            ['user_id','=',$this->user->id],
            ['batch_id','=',$batch->id],
            ['exam_id','=',$exam->id],
        ])->first();

        if(!$result)
        {
            return response()->json(['error'=>'Exam Not Solved Yet'], 403);
        }

        $evaluations=Evaluation::where([
            ['user_id','=',$this->user->id],
            ['batch_id','=',$batch->id],
            ['exam_id','=',$exam->id],
        ])->get();

        return response()->json([
            'batch_id' => $batch->id,
            'batch_name' => $batch->name,
            'batch_slug' => $batch->slug,
            'batch_status' => $batch->status,
            'class_status' => $batch->class_status,
            'exam_id' => $exam->id,
            'exam_name' => $exam->name,
            'exam_description' => $exam->description,
            'exam_time' => $exam->exam_time.':00',
            'exam_result' => [
                'marks_per_question' => $exam->marks_per_question,
                'negative_marks_per_question' => $exam->negative_marks,
                'full_marks' => ($result->total_questions * $exam->marks_per_question),
                'total_questions' => $result->total_questions,
                'leaved_questions' => $result->leaved_questions,
                'correct_questions' => $result->correct_questions,
                'wrong_questions' => $result->wrong_questions,
                'marks_obtained' => (($result->correct_questions * $exam->marks_per_question) - ($result->wrong_questions * $exam->negative_marks)),
            ],
            'solutions' => $evaluations->map(function($sol){
                $stat = $sol->your_ans ? ($sol->your_ans == $sol->correct_ans ? 'Correct' : 'Wrong') : 'Leaved';
                return [
                    'question_id' => $sol->question_id,
                    'question' => $sol->getQuestion->name ?? '',
                    'option_a' => $sol->getQuestion->opt_a ?? '',
                    'option_b' => $sol->getQuestion->opt_b ?? '',
                    'option_c' => $sol->getQuestion->opt_c ?? '',
                    'option_d' => $sol->getQuestion->opt_d ?? '',
                    'option_correct' => $sol->getQuestion->opt_correct ?? '',
                    'my_option' => $sol->your_ans,
                    'solution_status' => $stat,
                ];
            }),
        ], 200);
    }

    public function save($batchID, $examID, Request $request)
    {
        $batch = Batch::find($batchID);
        if(!$batch)
        {
            return response()->json(['error'=>'Course Batch Not Found'], 404);
        }

        $exam = Exam::find($examID);
        if(!$exam)
        {
            return response()->json(['error'=>'Exam Not Found'], 404);
        }

        $validator=Validator::make($request->all(),[
            'batch_id'=>'numeric | required',
            'exam_id'=>'numeric | required',
            'total_questions'=>'numeric | required',
        ]);
 
        if($validator->fails()){
            return response()->json([$validator->errors()]);
        }

        $total_questions=$request->total_questions;
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
                
                if(isset($data['answer-'.$i])){
                    $ans = ucwords($data['answer-'.$i]);
                    if($correct_answer==$ans)
                    {
                        $correct_questions++;
                    }else{
                        $wrong_questions++;
                    }
                    $my_answer=$ans;
                }else{
                    $leaved_questions++;
                }
                
                Evaluation::create([
                    'user_id'=>$this->user->id,
                    'batch_id'=>$batch->id,
                    'exam_id'=>$exam->id,
                    'question_id'=>$question->id,
                    'correct_ans'=>$correct_answer,
                    'your_ans'=>$my_answer,
                ]);

            }

        }

        Result::create([
            'user_id'=>$this->user->id,
            'batch_id'=>$batch->id,
            'exam_id'=>$exam->id,
            'total_questions'=>$total_questions,
            'leaved_questions'=>$leaved_questions,
            'correct_questions'=>$correct_questions,
            'wrong_questions'=>$wrong_questions,
        ]);

        return response()->json([
            'message' => 'Your Exam Has Been Submitted.'
        ], 200);
    }
}
