<?php

namespace App\Http\Controllers\APIs\Student\MainCourse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Batch;
use App\Models\Exams\WrittenExam;
use App\Models\Exams\WrittenExamSolution;

class WrittenExamController extends Controller
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

        $writtenexams = $batch->writtenExams->map(function($exam) {
            $result = WrittenExamSolution::where([
                ['user_id','=',auth()->user()->id],
                ['exam_id','=',$exam->id]
            ])->first() ? true: false;

            return (object)[
                'is_solved' => $result,
                'batch_id' => $exam->batch->id,
                'batch_name' => $exam->batch->name,
                'batch_slug' => $exam->batch->slug,
                'batch_status' => $exam->batch->status,
                'class_status' => $exam->batch->class_status,
                'exam_id' => $exam->id,
                'exam_question' => $exam->question,
                'attempt_link' => url('api/v1/my/course/classroom/'.$exam->batch->id.'/written-exams/'.$exam->id.'/attempt'),
                'evaluation_link' => url('api/v1/my/course/classroom/'.$exam->batch->id.'/written-exams/'.$exam->id.'/view'),
            ];
        });

        return $writtenexams;
    }

    // public function index()
    // {
    //     $bookings=$this->user->bookings()->where('status','=','Verified')->get('batch_id')->toArray();
    //     $batches=[];
    //     foreach ($bookings as $booking) {
    //         $batches[]= $booking['batch_id'];
    //     }
    //     $batches=array_unique($batches);
    //     $writtenexams=WrittenExam::whereIn('batch_id',$batches)->get()
    //     ->map(function($exam) {
    //         $result=WrittenExamSolution::where([
    //             ['user_id','=',$this->user->id],
    //             ['exam_id','=',$exam->id]
    //         ])->first();
    //         $status=false;
    //         if($result)
    //         {
    //             $status=true;
    //         }
    //         return (object)[
    //             'is_solved' => $status,
    //             'batch_id' => $exam->batch->id,
    //             'batch_name' => $exam->batch->name,
    //             'batch_slug' => $exam->batch->slug,
    //             'exam_id' => $exam->id,
    //             'exam_question' => $exam->question,
    //             'attempt_link' => url('api/v1/my/course/classroom/'.$exam->batch->id.'/written-exams/'.$exam->id.'/attempt'),
    //             'evaluation_link' => url('api/v1/my/course/classroom/'.$exam->batch->id.'/written-exams/'.$exam->id.'/view'),
    //         ];

    //     });

    //     return $writtenexams;
    // }


    public function view($batchID,$examID)
    {
        $batch = Batch::find($batchID);
        if(!$batch)
        {
            return response()->json(['error'=>'Course Batch Not Found'], 404);
        }

        $exam = WrittenExam::find($examID);
        if(!$exam)
        {
            return response()->json(['error'=>'Exam Not Found'], 404);
        }

        $result=WrittenExamSolution::where([
            ['user_id','=',$this->user->id],
            ['exam_id','=',$exam->id]
        ])->first();
        
        if(!$result)
        {
            return response()->json(['error'=>'Exam Not Solve Yet'], 404);
        }

        return response()->json([
            'batch_id' => $batch->id,
            'batch_name' => $batch->name,
            'batch_slug' => $batch->slug,
            'batch_status' => $batch->status,
            'class_status' => $batch->class_status,
            'course_name' =>$batch->course->name, 
            'exam_id' => $exam->id,
            'exam_question' => $exam->question,
            'my_solution' => $result->answer,
            'solution_remarks' => $result->remarks,
                        
        ], 200);
    }

    public function attempt($batchID,$examID)
    {
        $batch = Batch::find($batchID);
        if(!$batch)
        {
            return response()->json(['error'=>'Course Batch Not Found'], 404);
        }

        $exam = WrittenExam::find($examID);
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
            'course_name'=> $batch->course->name,
            'exam_id' => $exam->id,
            'exam_question' => $exam->question,
            'form_post_link' => url('api/v1/my/course/classroom/'.$batch->id.'/written-exams/'.$exam->id.'/save'),
            
        ], 200);
    }

    public function save($batchID,$examID, Request $request)
    {
        $batch = Batch::find($batchID);
        if(!$batch)
        {
            return response()->json(['error'=>'Course Batch Not Found'], 404);
        }

        $exam = WrittenExam::find($examID);
        if(!$exam)
        {
            return response()->json(['error'=>'Exam Not Found'], 404);
        }

        $validator=Validator::make($request->all(),[
            'batch_id'=>'numeric | required',
            'exam_id'=>'numeric | required',
            'answer'=>'required|string'
        ]);
 
        if($validator->fails()){
            return response()->json([$validator->errors()]);
        }

        WrittenExamSolution::create([
            'user_id'=>$this->user->id,
            'exam_id'=>$exam->id,
            'answer'=>$request->answer,
        ]);

        return response()->json([
            'message' => 'Your Exam Answer Has Been Submitted.'
        ], 200);
    }
}
