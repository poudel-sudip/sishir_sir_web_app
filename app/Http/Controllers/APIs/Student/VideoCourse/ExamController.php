<?php

namespace App\Http\Controllers\APIs\Student\VideoCourse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\VideoCourse\VideoCourse;
use App\Models\VideoCourse\VideoBooking;
use App\Models\VideoCourse\VideoExam;
use App\Models\VideoCourse\VideoExamResult;
use App\Models\VideoCourse\VideoExamEvaluation;
use App\Models\Exams\Exam;
use App\Models\Exams\Question;

class ExamController extends Controller
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

    public function index($bookingID)
    {
        $booking = VideoBooking::find($bookingID);
        if(!$booking)
        {
            return response()->json(['error'=>'Booking Not Found'], 404);
        }

        if($booking->status != 'Verified')
        {
            return response()->json(['error'=>'This Booking is not Verified. Please Contact Administrator.'], 403);
        }

        $course = $booking->course;
        if(!$course)
        {
            return response()->json(['error'=>'Booked Course Not Found'], 404);
        }

        $exams =[];
        $exams= $course->exams->map(function($exam) use($booking) {

            $result=VideoExamResult::where([
                ['user_id','=',$this->user->id],
                ['course_id','=',$exam->course_id],
                ['exam_id','=',$exam->exam_id]
                ])->first();

            $status=false;
            if($result)
            {
                $status=true;
            }
            $ex = $exam->exam;

            return (object)[
                'exam_id' => $ex->id,
                'course_name' => $exam->course->name ?? '',
                'exam_name' => $ex->name,
                'exam_time' => $ex->exam_time.':00',
                'is_solved' => $status,
                'attempt_link' => url('api/v1/my/video-course/'.$booking->id.'/exams/'.$ex->id.'/attempt'),
                'evaluation_link' => url('api/v1/my/video-course/'.$booking->id.'/exams/'.$ex->id.'/view'),
                'reset_link' => url('api/v1/my/video-course/'.$booking->id.'/exams/'.$ex->id.'/reset'),
            ];
        });

        return response()->json([
            'course' => [
                'id' => $course->id,
                'name' => $course->name,
                'slug' => $course->slug,
                'thumbnail' => $course->thumbnail,
                'category' => $course->category->name ?? '',
            ],
            'exams' => $exams,
            
        ]);
    }


    public function attemptExam($bookingID,$examID)
    {
        $booking = VideoBooking::find($bookingID);
        if(!$booking)
        {
            return response()->json(['error'=>'Booking Not Found'], 404);
        }

        if($booking->status != 'Verified')
        {
            return response()->json(['error'=>'This Booking is not Verified. Please Contact Administrator.'], 403);
        }

        $course = $booking->course;
        if(!$course)
        {
            return response()->json(['error'=>'Video Course Not Found'], 404);
        }

        $exam = Exam::find($examID);
        if(!$exam)
        {
            return response()->json(['error'=>'Exam Not Found'], 404);
        }

        return response()->json([
            'course_id' => $course->id,
            'course_name' => $course->name,
            'course_slug' => $course->slug,
            'exam_id' => $exam->id,
            'exam_name' => $exam->name,
            'exam_description' => $exam->description,
            'exam_time' => $exam->exam_time.':00',
            'marks_per_question' => $exam->marks_per_question,
            'negative_marks_per_question' => $exam->negative_marks,
            'form_post_link' => url('api/v1/my/video-course/'.$booking->id.'/exams/'.$exam->id.'/save'),
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

    public function viewExam($bookingID,$examID)
    {
        $booking = VideoBooking::find($bookingID);
        if(!$booking)
        {
            return response()->json(['error'=>'Booking Not Found'], 404);
        }

        if($booking->status != 'Verified')
        {
            return response()->json(['error'=>'This Booking is not Verified. Please Contact Administrator.'], 403);
        }

        $course = $booking->course;
        if(!$course)
        {
            return response()->json(['error'=>'Video Course Not Found'], 404);
        }

        $exam = Exam::find($examID);
        if(!$exam)
        {
            return response()->json(['error'=>'Exam Not Found'], 404);
        }

        $result=VideoExamResult::where([
            ['user_id','=',$this->user->id],
            ['course_id','=',$course->id],
            ['exam_id','=',$exam->id],
        ])->first();

        if(!$result)
        {
            return response()->json(['error'=>'Exam Not Solved Yet'], 403);
        }

        $evaluations=VideoExamEvaluation::where([
            ['user_id','=',$this->user->id],
            ['course_id','=',$course->id],
            ['exam_id','=',$exam->id],
        ])->get();

        return response()->json([
            'course_id' => $course->id,
            'course_name' => $course->name,
            'course_slug' => $course->slug,
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

    public function saveExam($bookingID, $examID, Request $request)
    {
        $booking = VideoBooking::find($bookingID);
        if(!$booking)
        {
            return response()->json(['error'=>'Booking Not Found'], 404);
        }

        if($booking->status != 'Verified')
        {
            return response()->json(['error'=>'This Booking is not Verified. Please Contact Administrator.'], 403);
        }

        $course = $booking->course;
        if(!$course)
        {
            return response()->json(['error'=>'Video Course Not Found'], 404);
        }

        $exam = Exam::find($examID);
        if(!$exam)
        {
            return response()->json(['error'=>'Exam Not Found'], 404);
        }

        $validator=Validator::make($request->all(),[
            'course_id'=>'numeric | required',
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
                
                VideoExamEvaluation::create([
                    'user_id'=>$this->user->id,
                    'course_id'=>$course->id,
                    'exam_id'=>$exam->id,
                    'question_id'=>$question->id,
                    'correct_ans'=>$correct_answer,
                    'your_ans'=>$my_answer,
                ]);

            }

        }

        VideoExamResult::create([
            'user_id'=>$this->user->id,
            'course_id'=>$course->id,
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

    public function resetExam($bookingID,$examID)
    {
        $booking = VideoBooking::find($bookingID);
        if(!$booking)
        {
            return response()->json(['error'=>'Booking Not Found'], 404);
        }

        if($booking->status != 'Verified')
        {
            return response()->json(['error'=>'This Booking is not Verified. Please Contact Administrator.'], 403);
        }

        $course = $booking->course;
        if(!$course)
        {
            return response()->json(['error'=>'Video Course Not Found'], 404);
        }

        $exam = Exam::find($examID);
        if(!$exam)
        {
            return response()->json(['error'=>'Exam Not Found'], 404);
        }

        $result=VideoExamResult::where([
            ['user_id','=',$this->user->id],
            ['course_id','=',$course->id],
            ['exam_id','=',$exam->id],
        ])->delete();

        $evaluations=VideoExamEvaluation::where([
            ['user_id','=',$this->user->id],
            ['course_id','=',$course->id],
            ['exam_id','=',$exam->id],
        ])->delete();

        return response()->json([
            'success' => 'The Exam Solution Has Been Reset.',
        ], 200);
    }
}
