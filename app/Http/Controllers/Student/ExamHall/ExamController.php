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
use App\Helpers\CustomPdfHelper;

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

        $remarks = [];

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

        $remarks = json_encode($remarks);

        ExamHallResults::create([
            'user_id'=>$user->id,
            'category_id'=>$category->id,
            'exam_id'=>$exam->id,
            'total_questions'=>$total_questions,
            'leaved_questions'=>$leaved_questions,
            'correct_questions'=>$correct_questions,
            'wrong_questions'=>$wrong_questions,
            'remarks' => $remarks,
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

        
        $total_questions = $result->total_questions;
        $correct_questions = $result->correct_questions;
        $wrong_questions = $result->wrong_questions;
        $leaved_questions = $result->leaved_questions;

        $marks_obtained = $correct_questions * ($exam->marks_per_question ?? 0) - ($wrong_questions * $exam->negative_marks ?? 0);
        $marks_obtained = max($marks_obtained, 0); 
        $percentage = intval($correct_questions / $total_questions * 100) ?? 0;
        $grade_info = (object)$this->getGradeInfo($percentage);


        $analysis = (object)[
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

        return view('student.examhall.exams.showresult',[
            'result'=>$result,
            'answers'=>$evaluations,
            'category'=>$category,
            'exam'=>$exam,
            'analysis'=>$analysis,
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

    public function downloadQuestionPdf(ExamHallCategories $category, Exam $exam)
    {
        // dd($category,$exam);

        $etime = explode(':',$exam->exam_time);
        $etimestr = trim(($etime[0] > 0 ? ((int)$etime[0].' Hour') : '').' '.((int)$etime[1].' Minutes'))  ;
        $exam->exam_solve_time = $etimestr;
        $exam->question_count = $exam->questions()->count();

        $html = view('exports.pdf.mcq_exam_questions', compact('exam'))->render();
        $symbols = array("\"", "/", "|");
        $title = str_replace($symbols,'-',$exam->name).' MCQ Questions';

        return CustomPdfHelper::createPdf($title,$html);  
        
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
