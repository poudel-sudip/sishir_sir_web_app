<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OpenExams\OpenExam;
use Illuminate\Support\Facades\URL;
use App\Models\Exams\Question;
use App\Models\OpenExams\OpenExamResult;
use App\Models\ExamHall\ExamHallCategories;
use App\Helpers\Helper;
use App\Models\Categories;
use App\Helpers\CustomPdfHelper;
use App\Models\Advertisement;
use App\Models\Exams\DailyMCQQuestion;

class PublicExamController extends Controller
{
    public function examlist(Request $request)
    {
        $data = [];
        
        $data['premium_exams'] = ExamHallCategories::where('status','Active')
        ->orderByDesc('id')
        ->paginate(12);

        $data['free_exams'] = OpenExam::where('result_status','=','Unpublished')
        ->get()
        ->sortByDesc('id')
        ->values();

        $data['exam_categories'] = Categories::where('status','=','Active')
        ->where('type','=','exam_hall')
        ->orderBy('order')
        ->whereHas('premium_exams',function($b){
            $b->where('status','=','Active');
        })
        ->get(['id','name','slug','order','status'])
        ->values();

        $data['sidebar_ad'] = Advertisement::where('status','Active')->where('position','page_sidebar_ad')->first();

        // dd($data);
        return view('front.publicexams.examslist',$data);
    }

    public function examform($eid)
    {
        $exam=OpenExam::where('id','=',$eid)->where('result_status','=','Unpublished')->first();
        if(!$exam)
        {
           abort(404);
        }

        $exam->exam_attempts = $exam->results()->count();
        $exam->exam_questions = $exam->exam->questions()->count() ?? 0;
        $etime = explode(':',$exam->exam->exam_time ?? '00:00');
        $etimestr = trim(($etime[0] > 0 ? ((int)$etime[0].' Hour') : '').' '.((int)$etime[1].' Minutes'))  ;
        $exam->exam_time = $etimestr;

        unset($exam->exam);

        $user = null;
        if(auth()->check())
        {
            $user = (object) auth()->user()->only(['id','name','contact','email']);
        }

        // dd($exam);
        return view('front.publicexams.examform',compact('exam','user'));
    }

    public function examshow(Request $request, $eid)
    {
        $request->validate([
            'name'=>'required|string|min:3',
            'email'=>'required|email',
            'contact'=>'required|numeric|digits:10',
        ]);

        $openexam=OpenExam::where('id','=',$eid)->where('result_status','=','Unpublished')->first();
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

    public function examsave(Request $request, $eid)
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
            'view_pdf' => $exam->exam->view_pdf ?? 0,
        ]);
    }

    public function resultlist()
    {
        $exams=OpenExam::where('result_status','=','Published')->get()->sortByDesc('id');
        return view('front.publicexams.resultlist',compact('exams'));
    }

    public function resultshow($eid)
    {
        $exam=OpenExam::where('id','=',$eid)->where('result_status','=','Published')->first();
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

    public function premiumExamShow($eid)
    {
        $exam = ExamHallCategories::where('id','=',$eid)
        ->where('status','=','Active')
        ->withCount(['category_exams as mcq_count' => function($ch){
            $ch->whereHas('exam',function($e){
                $e->where('status','=','Active');
            });            
        }])
        ->withCount(['category_exams as video_count' => function($ch){
            $ch->whereHas('exam',function($e){
                $e->where('status','=','Active')
                ->where('answer_video','!=','');
            });             
        }])
        ->withCount(['category_exams as pdf_count' => function($ch){
            $ch->whereHas('exam',function($e){
                $e->where('status','=','Active')
                ->where('answer_pdf','!=','');
            });            
        }])
        ->first();

        // $exam=ExamHallCategories::where('slug','=',$slug)->first();
        if(!$exam)
        {
           abort(404);
        }

        
        $exam->mcq_sets = $exam->category_exams()
        ->with('exam:id,name,status')
        ->whereHas('exam',function($e){
            $e->where('status','=','Active');
        })
        ->get()
        ->sortByDesc('id')
        ->values();

        $mcq_question_count = 0;
        foreach($exam->mcq_sets as $e)
        {
            try 
            {
                $que_count = $e->exam->questions()->count() ?? 0;
                $mcq_question_count += $que_count;
            } 
            catch (\Throwable $th) {
                //throw $th;
            }
            
        }

        $exam->mcq_question_count = $mcq_question_count;

        // dd($exam);
        // $pgurl = "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $pgurl = strtok($_SERVER['REQUEST_URI'], '?');
        $counterData = Helper::pageCounterCounts('Premium Exam Show',$pgurl);

        return view('front.publicexams.showpremiumexam',compact('exam','counterData'));
    }

    public function categoryPremiumExamList($cat, Request $request)
    {
        $exam_group = Categories::where('status','=','Active')
        ->where('type','=','exam_hall')
        ->where('id','=',$cat)
        ->first();

        if(!$exam_group)
        {
            abort(404);
        }

        $data = [];
        
        $data['exam_group'] = $exam_group;

        $data['premium_exams'] = $exam_group->premium_exams()
        ->where('status','Active')
        ->orderByDesc('id')
        ->paginate(12);

        $data['free_exams'] = OpenExam::where('result_status','=','Unpublished')
        ->get()
        ->sortByDesc('id')
        ->values();

        $data['exam_categories'] = Categories::where('status','=','Active')
        ->where('type','=','exam_hall')
        ->orderBy('order')
        ->whereHas('premium_exams',function($b){
            $b->where('status','=','Active');
        })
        ->get(['id','name','slug','order','status'])
        ->values();


        // dd($data);
        return view('front.publicexams.category_examslist',$data);
        
    }

    public function examQuestionsPdfDownload($eid, Request $request)
    {
        $openexam=OpenExam::where('id','=',$eid)->where('result_status','=','Unpublished')->first();
        if(!$openexam)
        {
           abort(404);
        }

        $exam = $openexam->exam;
        if(!$exam)
        {
           abort(404);
        }

        $etime = explode(':',$exam->exam_time);
        $etimestr = trim(($etime[0] > 0 ? ((int)$etime[0].' Hour') : '').' '.((int)$etime[1].' Minutes'))  ;
        $exam->exam_solve_time = $etimestr;
        $exam->question_count = $exam->questions()->count();
        
        // return view('exports.pdf.mcq_exam_questions',compact('exam'));
        $html = view('exports.pdf.mcq_exam_questions', compact('exam'))->render();

        $symbols = array("\"", "/", "|");
        $title = str_replace($symbols,'-',$exam->name).' MCQ Questions';

        return CustomPdfHelper::createPdf($title,$html);
                
    }


    public function playDailyQuestionQuiz(Request $request)
    {
        
        // $data['questions'] = DailyMCQQuestion::whereDate('show_date','<=',date('Y-m-d'))->orderByDesc('show_date')->take(100)->get()->values();
        $data['questions'] = DailyMCQQuestion::whereDate('show_date','<=',date('Y-m-d'))->inRandomOrder()->take(100)->get()->values();

        // dd($data);
        return view('front.publicexams.play_daily_question_quiz',$data);
    }

}
