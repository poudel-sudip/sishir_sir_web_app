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
                
        $data['mcq_exams'] = $batch->batchExams()
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

        for ($i=1; $i <= $total_questions; $i++) { 
            if(isset($data['question-'.$i]))
            {                  
                $question = Question::where('id',$data['question-'.$i])->first(['id','opt_correct']);
                $correct_answer = ucwords($question->opt_correct);
                $my_answer = ucwords($data['ans-'.$i] ?? '');

                if($my_answer){
                    if($correct_answer == $my_answer)
                    {
                        $correct_questions++;
                    }else{
                        $wrong_questions++;
                    }
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

        return redirect('/student/course-bookings/'.$booking->id.'/mcq-exams');
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
        return redirect('/student/course-bookings/'.$booking->id.'/mcq-exams');
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
        
        return view('student.courses.mcq-exams.result',$data);
    }

 
}
