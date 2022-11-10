<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OpenExams\OpenExam;
use App\Models\Exams\Question;
use App\Models\OpenExams\OpenExamResult;
use App\Models\ExamHall\ExamHallCategories;


class PublicExamController extends Controller
{
    public function examlist()
    {
        $premiumExams=ExamHallCategories::where('status','Active')->get();
        $exams=OpenExam::where('result_status','=','Unpublished')->get()->sortByDesc('id');
        return view('front.publicexams.examslist',compact('exams','premiumExams'));
    }

    public function examform($examslug)
    {
        $exam=OpenExam::where('slug','=',$examslug)->first();
        if(!$exam)
        {
           abort(404);
        }

        return view('front.publicexams.examform',compact('exam'));
    }

    public function examshow(Request $request, $examslug)
    {
        $request->validate([
            'name'=>'required|string|min:3',
            'email'=>'required|email',
            'contact'=>'required|numeric|digits:10',
        ]);

        $openexam=OpenExam::where('slug','=',$examslug)->first();
        if(!$openexam)
        {
           abort(404);
        }
        $exam = $openexam->exam;
        // dd($exam,$openexam);
        $user=(object)[
            'name'=>$request->name,
            'email'=>$request->email,
            'contact'=>$request->contact,
            'courses'=>$request->courses
        ];
        
        return view('front.publicexams.attemptexam',compact('user','exam','openexam'));
    }

    public function examsave(Request $request, $examslug)
    {

        $total_questions=$request->index;
        $leaved_questions=0;
        $correct_questions=0;
        $wrong_questions=0;
        $username=$request->user_name;
        $usercontact=$request->user_contact;
        $useremail=$request->user_email;
        $courses=$request->courses;
        $data=$request->all();
        $exam=OpenExam::findOrFail($data['exam_id']);

        for ($i=1; $i <= $total_questions; $i++) 
        { 
            if(isset($data['question-'.$i]))
            {                  
                $question=Question::where('id',$data['question-'.$i])->first();
                if(isset($data['ans-'.$i])){
                    if($question->opt_correct==$data['ans-'.$i])
                    {
                        $correct_questions++;
                    }else{
                        $wrong_questions++;
                    }
                }else{
                    $leaved_questions++;
                }
            }
        }

        $result=OpenExamResult::create([
            'exam_id'=>$exam->id,
            'name'=>$username,
            'email'=>$useremail,
            'contact'=>$usercontact,
            'courses'=>$courses,
            'total_questions'=>$total_questions,
            'leaved_questions'=>$leaved_questions,
            'correct_questions'=>$correct_questions,
            'wrong_questions'=>$wrong_questions,
        ]);

        return view('front.publicexams.examsuccess',[
            'result'=>$result,
            'status'=>'1',
        ]);
    }

    public function resultlist()
    {
        $exams=OpenExam::where('result_status','=','Published')->get()->sortByDesc('id');
        return view('front.publicexams.resultlist',compact('exams'));
    }

    public function resultshow($examslug)
    {
        $exam=OpenExam::where('slug','=',$examslug)->first();
        if(!$exam)
        {
           abort(404);
        }
        $results=$exam->results;
        return view('front.publicexams.resultshow',compact('exam','results'));
    }

    public function premiumExamShow($slug)
    {
        $exam=ExamHallCategories::where('slug','=',$slug)->first();
        if(!$exam)
        {
           abort(404);
        }

        return view('front.publicexams.showpremiumexam',compact('exam'));
    }

}
