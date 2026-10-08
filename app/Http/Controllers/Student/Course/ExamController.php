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
use App\Models\Booking;

// use Illuminate\Support\Facades\Gate;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function McqExamList(Booking $booking)
    {
        if($booking->status != 'Verified')
        {
            abort(403,'Cannot Access MCQ Exams Of Unverified Booking.');
        }
        $batch = $booking->batch;
        if(!$batch)
        {
            abort(404,'Batch Not Found.');
        }
        
        $data = [];
        $data['booking'] = $booking;
        $data['batch'] = $batch;
                
        $data['mcq_exams'] = $batch->batchNormalExams()
        ->whereHas('exam')
        ->get()
        ->map(function($exam) use($batch) {
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
        })
        ->values();

        return view('student.courses.mcq-exams.index',$data);
    }

    public function McqExamAttempt(Booking $booking, Exam $exam)
    {
        if($booking->status != 'Verified')
        {
            abort(403,'Cannot Access MCQ Exams Of Unverified Booking.');
        }
        $batch = $booking->batch;
        if(!$batch)
        {
            abort(404,'Batch Not Found.');
        }
        
        $data = [];
        $data['booking'] = $booking;
        $data['batch'] = $batch;
        $data['exam'] = $exam;

        return view('student.courses.mcq-exams.attempt',$data);
    }

    public function McqExamSave(Request $request, Booking $booking, Exam $exam)
    {
        if($booking->status != 'Verified')
        {
            abort(403,'Cannot Access MCQ Exams Of Unverified Booking.');
        }
        $batch = $booking->batch;
        if(!$batch)
        {
            abort(404,'Batch Not Found.');
        }

        $user=auth()->user();

        $total_questions=$request->index;
        $leaved_questions=0;
        $correct_questions=0;
        $wrong_questions=0;
        $data=$request->all();
        
        $remarks = [];

        for ($i=1; $i <= $total_questions; $i++) { 
            if(isset($data['question-'.$i]))
            {                  
                $question = Question::where('id',$data['question-'.$i])->first(['id','opt_correct']);
                $correct_answer = ucwords($question->opt_correct);
                $my_answer="";
                
                if(isset($data['ans-'.$i])){
                    $ans=explode("=>",$data['ans-'.$i]);
                    if($question->opt_correct==$ans[0])
                    {
                        $correct_questions++;
                        $remarks['q-'.$i] = 'c';
                    }else{
                        $wrong_questions++;
                        $remarks['q-'.$i] = 'w';
                    }
                    $my_answer=$ans[0];
                }else{
                    $leaved_questions++;
                    $remarks['q-'.$i] = 'l';
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

        $remarks = json_encode($remarks);

        Result::create([
            'user_id'=>$user->id,
            'batch_id'=>$batch->id,
            'exam_id'=>$exam->id,
            'total_questions'=>$total_questions,
            'leaved_questions'=>$leaved_questions,
            'correct_questions'=>$correct_questions,
            'wrong_questions'=>$wrong_questions,
            'remarks' => $remarks,
        ]);

        return redirect('/student/online-course-bookings/'.$booking->id.'/mcq-exams');
    }

    public function McqExamReset(Request $request, Booking $booking, Exam $exam)
    {
        if($booking->status != 'Verified')
        {
            abort(403,'Cannot Access MCQ Exams Of Unverified Booking.');
        }
        $batch = $booking->batch;
        if(!$batch)
        {
            abort(404,'Batch Not Found.');
        }

        // dd($batch,$exam);
        $user = auth()->user();
        $result = Result::where([
            ['user_id','=',$user->id],
            ['batch_id','=',$batch->id],
            ['exam_id','=',$exam->id],
        ])->delete();

        $evaluations = Evaluation::where([
            ['user_id','=',$user->id],
            ['batch_id','=',$batch->id],
            ['exam_id','=',$exam->id],
        ])->delete();

        // dd($result,$evaluations);
        return redirect('/student/online-course-bookings/'.$booking->id.'/mcq-exams');
    }

    public function McqExamView(Booking $booking, Exam $exam)
    {
        if($booking->status != 'Verified')
        {
            abort(403,'Cannot Access MCQ Exams Of Unverified Booking.');
        }
        $batch = $booking->batch;
        if(!$batch)
        {
            abort(404,'Batch Not Found.');
        }

        $user = auth()->user();
        $result = Result::where([
            ['user_id','=',$user->id],
            ['batch_id','=',$batch->id],
            ['exam_id','=',$exam->id],
        ])->first();

        $evaluations = Evaluation::where([
            ['user_id','=',$user->id],
            ['batch_id','=',$batch->id],
            ['exam_id','=',$exam->id],
        ])->get();

        $data = [];
        $data['result'] = $result;
        $data['answers'] = $evaluations;
        $data['batch'] = $batch;
        $data['exam'] = $exam;
        
        $total_questions = $result->total_questions;
        $correct_questions = $result->correct_questions;
        $wrong_questions = $result->wrong_questions;
        $leaved_questions = $result->leaved_questions;

        $marks_obtained = $correct_questions * ($exam->marks_per_question ?? 0) - ($wrong_questions * $exam->negative_marks ?? 0);
        $marks_obtained = max($marks_obtained, 0); 
        $percentage = intval($correct_questions / $total_questions * 100) ?? 0;
        $grade_info = (object)$this->getGradeInfo($percentage);


        $data['analysis'] = (object)[
            'id' => $exam->id,
            'title' => $exam->name,
            'user_name' => $user->name,
            'result_id' => $result->id,
            'total_questions' => $total_questions,
            'full_marks' => $total_questions * ($exam->marks_per_question ?? 1),
            'correct_questions' => $correct_questions,
            'wrong_questions' => $wrong_questions,
            'leaved_questions' => $leaved_questions,
            'marks_obtained' => $marks_obtained,
            'percentage' => $percentage,
            'grade' => $grade_info->grade,
            'grade_class' => $grade_info->class,
            'grade_msg' => $grade_info->msg,
        ];


        return view('student.courses.mcq-exams.result',$data);
    }

 
    public function FinalExamAttempt(Booking $booking, Request $request)
    {
        if($booking->status != 'Verified')
        {
            abort(403,'Cannot Access Final Exams Of This Booking.');
        }
        $batch = $booking->batch;
        if(!$batch)
        {
            abort(404,'Batch Not Found.');
        }
        
        $data = [];
        $mcq_exam = $batch->batchFinalExams()
        ->whereHas('exam')
        ->inRandomOrder()
        ->take(1)
        ->first();

        if(!$mcq_exam)
        {
            abort(403, 'This course doesnot contain final exam. please try again later.');
        }

        $exam = $mcq_exam->exam;

        $data['booking'] = $booking;
        $data['batch'] = $batch;
        $data['exam'] = $exam;

        // dd($data);
        return view('student.courses.final-exam.attempt',$data);
    }

    public function FinalExamSave(Request $request, Booking $booking, Exam $exam)
    {
        if($booking->status != 'Verified')
        {
            abort(403,'Cannot Access MCQ Exams Of Unverified Booking.');
        }
        $batch = $booking->batch;
        if(!$batch)
        {
            abort(404,'Batch Not Found.');
        }

        $user=auth()->user();

        $total_questions=$request->index;
        $leaved_questions=0;
        $correct_questions=0;
        $wrong_questions=0;
        $data=$request->all();
        
        $remarks = [];

        for ($i=1; $i <= $total_questions; $i++) { 
            if(isset($data['question-'.$i]))
            {                  
                $question = Question::where('id',$data['question-'.$i])->first(['id','opt_correct']);
                $correct_answer = ucwords($question->opt_correct);
                $my_answer="";
                
                if(isset($data['ans-'.$i])){
                    $ans=explode("=>",$data['ans-'.$i]);
                    if($question->opt_correct==$ans[0])
                    {
                        $correct_questions++;
                        $remarks['q-'.$i] = 'c';
                    }else{
                        $wrong_questions++;
                        $remarks['q-'.$i] = 'w';
                    }
                    $my_answer=$ans[0];
                }else{
                    $leaved_questions++;
                    $remarks['q-'.$i] = 'l';
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

        $remarks = json_encode($remarks);

        $result = Result::create([
            'user_id'=>$user->id,
            'batch_id'=>$batch->id,
            'exam_id'=>$exam->id,
            'total_questions'=>$total_questions,
            'leaved_questions'=>$leaved_questions,
            'correct_questions'=>$correct_questions,
            'wrong_questions'=>$wrong_questions,
            'remarks' => $remarks,
        ]);

        $final_result = [];
        $final_result['exam_id'] = $exam->id;
        $final_result['exam_title'] = $exam->name;
        $final_result['exam_time'] = $exam->exam_time;
        $final_result['exam_date'] = date('Y-m-d H:i');
        $final_result['tq'] = $total_questions;
        $final_result['cq'] = $correct_questions;
        $final_result['wq'] = $wrong_questions;
        $final_result['lq'] = $leaved_questions;
        $final_result['fm'] = $total_questions * ($exam->marks_per_question ?? 1);
        $final_result['mo'] = round(($correct_questions * ($exam->marks_per_question ?? 1)) - ($wrong_questions * ($exam->negative_marks ?? 0) ),2);

        $final_remarks = json_encode($final_result);
        $booking->update([
            'status' => 'Completed',
            'description' => $final_remarks,
        ]);

        return redirect('/student/online-course-bookings/'.$booking->id.'/certificate');
    }

    private function getGradeInfo($percentage) {
        if ($percentage >= 90) return ['grade' => 'A+', 'class' => 'grade-a', 'msg' => 'Outstanding Performance! 🎉'];
        if ($percentage >= 80) return ['grade' => 'A', 'class' => 'grade-a', 'msg' => 'Excellent Work! 👏'];
        if ($percentage >= 70) return ['grade' => 'B', 'class' => 'grade-b', 'msg' => 'Good Job! 👍'];
        if ($percentage >= 60) return ['grade' => 'C', 'class' => 'grade-c', 'msg' => 'Fair Performance 📚'];
        if ($percentage >= 50) return ['grade' => 'D', 'class' => 'grade-d', 'msg' => 'Needs Improvement 📖'];
        return ['grade' => 'F', 'class' => 'grade-f', 'msg' => 'Keep Practicing! 💪'];
    }

    private function formatTime($seconds) {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;
        return ($hours > 0 ? $hours . 'h ' : '') . $minutes . 'm ' . $secs . 's';
    }
}
