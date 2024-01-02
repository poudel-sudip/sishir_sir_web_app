<?php

namespace App\Http\Controllers\Admin\Exams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DailyQuestionsImport;
use App\Models\Exams\DailyMCQQuestion;
use Intervention\Image\Facades\Image as QuestionImage;

class DailyQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['questions'] = DailyMCQQuestion::orderByDesc('id')->take(500)->get();
        return view('admin.exams.daily.index',$data);
    }

    public function create()
    {
        return view('admin.exams.daily.create',$data=[]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'question'=>'required|string|min:5',
            'optionA'=>'required|string',
            'optionB'=>'required|string',
            'optionC'=>'string|nullable',
            'optionD'=>'string|nullable',
            'optionCorrect'=>'required|string|max:1',
            // 'rationale'=>'string|nullable',
        ]);

        $max = DailyMCQQuestion::max('show_date') ?? date('Y-m-d');
        $next = date('Y-m-d', strtotime('+1 day', strtotime($max)));
        // dd($request->all(),$max,$next);

        if(strtoupper($request->optionCorrect) =='A' || strtoupper($request->optionCorrect) =='B' || strtoupper($request->optionCorrect) =='C' || strtoupper($request->optionCorrect) =='D' )
        {
            DailyMCQQuestion::create([
                'question'=>$request->question,
                'opt_a'=>$request->optionA,
                'opt_b'=>$request->optionB,
                'opt_c'=>$request->optionC,
                'opt_d'=>$request->optionD,
                'opt_correct'=>strtoupper($request->optionCorrect),
                'show_date'=>$next,
                // 'rationale'=>$request->rationale,
            ]);
    
            return redirect('/admin/daily-mcq-questions')->with('success','Data Saved Successfully');    
        }
        else
        {
          return back()->withInput()->withErrors(['optionCorrect' => 'Please use English Alphabets(A,B,C,D) only.']);  
        }

    }

    public function show(DailyMCQQuestion $question)
    {
        $question_image = "question_images/question_".date('Y_m_d_',strtotime($question->show_date)).$question->id.".png";

        if(!file_exists(public_path($question_image)))
        {
            try 
            {
                $qtext = wordwrap(trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags('Question: '.$question->question)))),65,"\n",false);   
                $qtextline = substr_count( $qtext, "\n" );
                $qoptions = [
                    'A' => trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($question->opt_a)))),
                    'B' => trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($question->opt_b)))),
                    'C' => trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($question->opt_c)))),
                    'D' => trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($question->opt_d)))),
                ];

                $image = QuestionImage::make(public_path('question_images/question_bg.png'));

                $optionY = 150;
                $image->text($qtext, 75, $optionY, function ($font) {
                    $font->file(public_path('fonts/arial-bold.ttf')); 
                    $font->size(32);
                    $font->color('#02074e');
                    $font->align('left');
                    $font->valign('top');
                });

                $optionY = $optionY + 50 + ($qtextline*50);

                foreach ($qoptions as $key => $option) {

                    $optionText = wordwrap($option,70,"\n",false); 
                    $image->text(($key).'.', 120, $optionY, function ($font) {
                        $font->file(public_path('fonts/arial.ttf')); 
                        $font->size(32);
                        $font->color('#144389');
                        $font->align('left');
                        $font->valign('top');
                    });

                    $image->text($optionText, 160, $optionY, function ($font) {
                        $font->file(public_path('fonts/arial.ttf')); 
                        $font->size(32);
                        $font->color('#144389');
                        $font->align('left');
                        $font->valign('top');
                    });

                    $optonline = substr_count( $optionText, "\n" );
                    $optionY = $optionY + 45*($optonline+1); // Adjust vertical spacing between options
                }

                $image->save(public_path($question_image));
            } 
            catch (\Throwable $th) {
                //throw $th;
            }
            
        }
        
        $data['question'] = $question;
        $data['question_image'] = url($question_image);
        
        // dd($data);
        return view('admin.exams.daily.show',$data);
    }


    public function edit(DailyMCQQuestion $question)
    {
        $data['question'] = $question;
        return view('admin.exams.daily.edit',$data);
    }

    public function update(Request $request, DailyMCQQuestion $question)
    {
        $request->validate([
            'question'=>'required|string|min:5',
            'optionA'=>'required|string',
            'optionB'=>'required|string',
            'optionC'=>'string|nullable',
            'optionD'=>'string|nullable',
            'optionCorrect'=>'required|string|max:1',
            // 'rationale'=>'string|nullable',
        ]);

        // dd($request->all());

        $question->update([
            'question'=>$request->question,
            'opt_a'=>$request->optionA,
            'opt_b'=>$request->optionB,
            'opt_c'=>$request->optionC,
            'opt_d'=>$request->optionD,
            'opt_correct'=>strtoupper($request->optionCorrect),
        ]);

        return redirect('/admin/daily-mcq-questions')->with('success','Data Updated Successfully');

    }

    public function destroy(DailyMCQQuestion $question)
    {
        $question->delete();
        return redirect('/admin/daily-mcq-questions')->with('success','Data Deleated Successfully');
    
    }

    public function upload()
    {
        return view('admin.exams.daily.upload',$data=[]);
    }


    public function import(Request $request)
    {
        $request->validate([
            'file'=>'required',
        ]);
        Excel::import(new DailyQuestionsImport,request()->file('file'));
        return redirect('/admin/daily-mcq-questions');

    }

    public function comments(DailyMCQQuestion $question)
    {
        $data['question'] = $question;
        $data['comments'] = $question->comments()->orderByDesc('id')->get();
        return view('admin.exams.daily.comments',$data);
    }
}
