<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OpenExams\OpenExam;
use App\Models\Exams\Question;
use App\Models\OpenExams\OpenExamResult;
use App\Models\ExamHall\ExamHallCategories;
use App\Helpers\Helper;
use Illuminate\Support\Facades\URL;

class PublicExamController extends Controller
{
    public function examlist()
    {
        $premiumExams=ExamHallCategories::where('status','Active')->orderByDesc('id')->paginate(12);
        $exams=OpenExam::where('result_status','=','Unpublished')->get()->sortByDesc('id');
        return view('front.publicexams.examslist',compact('exams','premiumExams'));
    }

    public function examform($examslug)
    {
        $exam=OpenExam::where('slug','=',$examslug)->where('result_status','=','Unpublished')->first();
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

        $openexam=OpenExam::where('slug','=',$examslug)->where('result_status','=','Unpublished')->first();
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
        
        try 
        {
            $pageurl = URL::previous();
            $parsedurl = parse_url($pageurl);

            $data = [
                'name'=> $request->name,
                'email'=> $request->email,
                'contact'=> $request->contact,
                // 'remarks'=> $request->courses,
                'website' => $parsedurl['host'],
                'source_url' => $parsedurl['host'].$parsedurl['path'],
                'page_title' => $exam->name,
            ];

            $apiurl = "https://etutorclass.com/api/v1/collect-external-web-data";
            $ch = curl_init($apiurl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 6); // Set a timeout
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4); // Set a connection timeout
            $response = curl_exec($ch);
            curl_close($ch);
        
        } 
        catch (\Throwable $th) {
            //throw $th;
        }


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

        $remarks = [];
        $question_solutions = [];

        for ($i=1; $i <= $total_questions; $i++) 
        { 
            if(isset($data['question-'.$i]))
            {                  
                $question=Question::where('id',$data['question-'.$i])->first(['id','opt_correct']);
                if(isset($data['ans-'.$i])){
                    if($question->opt_correct==$data['ans-'.$i])
                    {
                        $correct_questions++;
                        $remarks['q-'.$i] = 'c';
                    }else{
                        $wrong_questions++;
                        $remarks['q-'.$i] = 'w';
                    }
                }else{
                    $leaved_questions++;
                    $remarks['q-'.$i] = 'l';
                }

                $question_solutions[$i.''] = $question->opt_correct;
            }
        }

        // $question_solutions = json_encode($question_solutions);

        $remarks = json_encode($remarks);

        // dd($request->all(),$remarks,$question_solutions);

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
            'remarks' => $remarks,
        ]);

        return view('front.publicexams.examsuccess',[
            'result'=>$result,
            'exam' => $exam,
            'question_solutions' => $question_solutions,
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
        $exam=OpenExam::where('slug','=',$examslug)->where('result_status','=','Published')->first();
        if(!$exam)
        {
           abort(404);
        }
        $results=$exam->results;
        // $pgurl = "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $pgurl = strtok($_SERVER['REQUEST_URI'], '?');
        $counterData = Helper::pageCounterCounts('Premium Exam Show',$pgurl);
        return view('front.publicexams.resultshow',compact('exam','results','counterData'));
    }

    public function premiumExamShow($slug)
    {
        $exam=ExamHallCategories::where('slug','=',$slug)->first();
        if(!$exam)
        {
           abort(404);
        }

        // $pgurl = "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $pgurl = strtok($_SERVER['REQUEST_URI'], '?');
        $counterData = Helper::pageCounterCounts('Premium Exam Show',$pgurl);

        return view('front.publicexams.showpremiumexam',compact('exam','counterData'));
    }

}
