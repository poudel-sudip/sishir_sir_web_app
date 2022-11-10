<?php

namespace App\Http\Controllers\student\Video;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoCourse\VideoBooking;
use App\Models\VideoCourse\VideoExam;
use App\Models\VideoCourse\VideoExamResult;
use App\Models\VideoCourse\VideoExamEvaluation;
use App\Models\Exams\Exam;
use App\Models\Exams\Question;

class ExamController extends Controller
{
    public function index(VideoBooking $booking)
    {
        $course = $booking->course;
        $exams =[];
        $exams= $course->exams->map(function($exam){

            $result=VideoExamResult::where([
                ['user_id','=',auth()->user()->id],
                ['course_id','=',$exam->course_id],
                ['exam_id','=',$exam->exam_id]
                ])->first();

            $status=false;
            if($result)
            {
                $status=true;
            }

            return (object)[
                'exam'=>$exam->exam,
                'course'=>$exam->course,
                'status'=>$status,
            ];
        });

        // dd($exams);
        return view('student.videocourse.exam.exams',compact('booking','course','exams'));
    }

    public function takeExam(VideoBooking $booking, Exam $exam)
    {
        $course = $booking->course;
        // dd($booking,$course,$exam);
        return view('student.videocourse.exam.attempt',compact('booking','exam','course'));
    }

    public function saveExam(Request $request, VideoBooking $booking, Exam $exam)
    {
        // dd($request->all(),$booking,$exam);
        $user=auth()->user();
        $total_questions=$request->index;
        $leaved_questions=0;
        $correct_questions=0;
        $wrong_questions=0;
        $data=$request->all();

        for ($i=1; $i <= $total_questions; $i++)
        { 
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

                VideoExamEvaluation::create([
                    'user_id'=>$user->id,
                    'course_id'=>$booking->course_id,
                    'exam_id'=>$exam->id,
                    'question_id'=>$question->id,
                    'correct_ans'=>$correct_answer,
                    'your_ans'=>$my_answer,
                ]);
            }
        }

        VideoExamResult::create([
            'user_id'=>$user->id,
            'course_id'=>$booking->course_id,
            'exam_id'=>$exam->id,
            'total_questions'=>$total_questions,
            'leaved_questions'=>$leaved_questions,
            'correct_questions'=>$correct_questions,
            'wrong_questions'=>$wrong_questions,
        ]);

        return redirect('/student/video-course/'.$booking->id.'/exams');
    }


    public function viewExam(VideoBooking $booking, Exam $exam)
    {
        $course = $booking->course;
        $user=auth()->user();
        $result=VideoExamResult::where([
            ['user_id','=',$user->id],
            ['course_id','=',$course->id],
            ['exam_id','=',$exam->id],
        ])->first();

        $evaluations=VideoExamEvaluation::where([
            ['user_id','=',$user->id],
            ['course_id','=',$course->id],
            ['exam_id','=',$exam->id],
        ])->get();

        return view('student.videocourse.exam.show',[
            'result'=>$result,
            'answers'=>$evaluations,
            'course'=>$course,
            'exam'=>$exam,
        ]);
    }

    public function resetExam(Request $request, VideoBooking $booking, Exam $exam)
    {
        $user=auth()->user();
        $course = $booking->course;

        $result=VideoExamResult::where([
            ['user_id','=',$user->id],
            ['course_id','=',$course->id],
            ['exam_id','=',$exam->id],
        ])->delete();

        $evaluations=VideoExamEvaluation::where([
            ['user_id','=',$user->id],
            ['course_id','=',$course->id],
            ['exam_id','=',$exam->id],
        ])->delete();

        return redirect('/student/video-course/'.$booking->id.'/exams');
    }

}
