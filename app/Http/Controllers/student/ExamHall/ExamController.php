<?php

namespace App\Http\Controllers\Student\ExamHall;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamHall\ExamHallBookings;
use App\Models\ExamHall\ExamHallCategories;
use App\Models\ExamHall\ExamHallExams;
use App\Models\ExamHall\ExamHallResults;
use App\Models\ExamHall\ExamHallEvaluation;
use App\Models\Exams\Exam;
use App\Models\Exams\Question;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(ExamHallCategories $category)
    {
        $cat_exams=[];
       
        $cat_exams=$category->category_exams->map(function($cat_exam){

            $result=ExamHallResults::where([
                ['user_id','=',auth()->user()->id],
                ['category_id','=',$cat_exam->category_id],
                ['exam_id','=',$cat_exam->exam_id]
                ])->first();
            $status=false;
            if($result)
            {
                $status=true;
            }

            return (object)[
                'exam'=>$cat_exam->exam,
                'category'=>$cat_exam->category,
                'status'=>$status,
            ];
        });

        // dd($category,$cat_exams);
        return view('student.examhall.exams.myexams',compact('category','cat_exams'));
    }

    public function takeExam(ExamHallCategories $category, Exam $exam)
    {
        // dd($category,$exam);
        return view('student.examhall.exams.takeexam',compact('category','exam'));
    }

    public function store(Request $request, ExamHallCategories $category, Exam $exam)
    {
        // dd($request->all(),$category,$exam);

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
                $correct_answer = $question->opt_correct;
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
                
                ExamHallEvaluation::create([
                    'user_id'=>$user->id,
                    'category_id'=>$category->id,
                    'exam_id'=>$exam->id,
                    'question_id'=>$question->id,
                    'correct_ans'=>$correct_answer,
                    'your_ans'=>$my_answer,
                ]);

            }

        }

        ExamHallResults::create([
            'user_id'=>$user->id,
            'category_id'=>$category->id,
            'exam_id'=>$exam->id,
            'total_questions'=>$total_questions,
            'leaved_questions'=>$leaved_questions,
            'correct_questions'=>$correct_questions,
            'wrong_questions'=>$wrong_questions,
        ]);

        return redirect('/student/exam-bookings/'.$category->id.'/exams');
    }

    public function show(ExamHallCategories $category, Exam $exam)
    {
        $user=auth()->user();
        $result=ExamHallResults::where([
            ['user_id','=',$user->id],
            ['category_id','=',$category->id],
            ['exam_id','=',$exam->id],
        ])->first();

        $evaluations=ExamHallEvaluation::where([
            ['user_id','=',$user->id],
            ['category_id','=',$category->id],
            ['exam_id','=',$exam->id],
        ])->get();
        // dd($evaluations->first()->question);
        return view('student.examhall.exams.showresult',[
            'result'=>$result,
            'answers'=>$evaluations,
            'category'=>$category,
            'exam'=>$exam,
        ]);
    }

    public function resetExam(Request $request, ExamHallCategories $category, Exam $exam)
    {
        // dd($request->all(),$category,$exam);
        $user=auth()->user();
        $result=ExamHallResults::where([
            ['user_id','=',$user->id],
            ['category_id','=',$category->id],
            ['exam_id','=',$exam->id],
        ])->delete();

        $evaluations=ExamHallEvaluation::where([
            ['user_id','=',$user->id],
            ['category_id','=',$category->id],
            ['exam_id','=',$exam->id],
        ])->delete();

        return redirect('/student/exam-bookings/'.$category->id.'/exams');
    }

}
