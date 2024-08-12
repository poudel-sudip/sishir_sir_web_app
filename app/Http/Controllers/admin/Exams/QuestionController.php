<?php

namespace App\Http\Controllers\Admin\Exams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exams\Exam;
use App\Models\Exams\Question;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExamQuestionsImport;
use App\Exports\Exams\ExamQuestionExport;

use App\Helpers\CustomPdfHelper;

class QuestionController extends Controller
{

    public function index(Exam $exam)
    {
        return view('admin.exams.questions.questionlist',compact('exam'));
    }

    public function create(Exam $exam)
    {
        return view('admin.exams.questions.questioncreate',compact('exam'));
    }

    public function store(Request $request, Exam $exam)
    {
        $request->validate([
            'question'=>'required|string|min:5',
            'optionA'=>'required|string',
            'optionB'=>'required|string',
            'optionC'=>'string|nullable',
            'optionD'=>'string|nullable',
            'optionCorrect'=>'required|string|max:1',
            'rationale'=>'string|nullable',
        ]);
        // dd($request->all());
        if(strtoupper($request->optionCorrect) =='A' || strtoupper($request->optionCorrect) =='B' || strtoupper($request->optionCorrect) =='C' || strtoupper($request->optionCorrect) =='D' )
        {
            $exam->questions()->create([
                'name'=>$request->question,
                'opt_a'=>$request->optionA,
                'opt_b'=>$request->optionB,
                'opt_c'=>$request->optionC,
                'opt_d'=>$request->optionD,
                'opt_correct'=>strtoupper($request->optionCorrect),
                'rationale'=>$request->rationale,
            ]);
    
            return redirect('/admin/exams/'.$exam->id.'/questions')->with('success','Data Saved Successfully');    
        }
        else
        {
          return back()->withInput()->withErrors(['optionCorrect' => 'Please use English Alphabets(A,B,C,D) only.']);  
        }

    }

    public function show(Exam $exam, Question $question)
    {
        return view('admin.exams.questions.questionshow',compact('exam','question'));
    }

    public function edit(Exam $exam, Question $question)
    {
        return view('admin.exams.questions.questionedit',compact('exam','question'));
    }

    public function update(Request $request, Exam $exam, Question $question)
    {
        $request->validate([
            'question'=>'required|string|min:5',
            'optionA'=>'required|string',
            'optionB'=>'required|string',
            'optionC'=>'string|nullable',
            'optionD'=>'string|nullable',
            'optionCorrect'=>'required|string|max:1',
            'rationale'=>'string|nullable',
        ]);
        // dd($request->all());

        $question->update([
            'name'=>$request->question,
            'opt_a'=>$request->optionA,
            'opt_b'=>$request->optionB,
            'opt_c'=>$request->optionC,
            'opt_d'=>$request->optionD,
            'opt_correct'=>strtoupper($request->optionCorrect),
            'rationale'=>$request->rationale,
        ]);

        return redirect('/admin/exams/'.$exam->id.'/questions')->with('success','Data Updated Successfully');

    }

    public function destroy(Exam $exam, Question $question)
    {
        $question->delete();
        return redirect('/admin/exams/'.$exam->id.'/questions')->with('success','Data Deleated Successfully');
    
    }

    public function upload(Exam $exam)
    {
        return view('admin.exams.questions.questionupload',compact('exam'));
    }

    public function import(Request $request, Exam $exam)
    {
        $request->validate([
            'file'=>'required',
        ]);
        Excel::import(new ExamQuestionsImport($exam),request()->file('file'));
        return redirect('/admin/exams/'.$exam->id.'/questions');

    }

    public function download(Request $request, Exam $exam)
    {
        $symbols = array("~"," ", "!", "@", "#", "$", "%", "^", "&", "*", "+", "=", ";", "\"", "<", ">", "/", "|", "`");

        $filename = str_replace($symbols,'_',$exam->name).'_questions.xlsx';
        return Excel::download(new ExamQuestionExport($exam), $filename);
    }

    public function pdfDownload(Request $request, Exam $exam)
    {

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

}

