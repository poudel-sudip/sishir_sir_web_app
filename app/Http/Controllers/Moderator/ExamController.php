<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Imports\ExamQuestionsImport;
use App\Exports\Exams\ExamQuestionExport;
use App\Exports\Exams\OpenExamResultExport;
use App\Models\Exams\ExamCategory;
use App\Models\Exams\Exam;
use App\Models\Exams\Question;
use App\Models\OpenExams\OpenExam;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function categoryIndex()
    {
        $user = auth()->user();
        // $data['categories'] = ExamCategory::where('user_id','=',$user->id)->get();
        $data['categories'] = ExamCategory::get();
        return view('moderator.exams.category.index',$data);
    }

    public function categoryCreate()
    {
        return view('moderator.exams.category.create');
    }

    public function categoryStore(Request $request)
    {
        $request->validate(['name'=>'string|required']);
        ExamCategory::create([
            'user_id' => auth()->user()->id,
            'title'=>$request->name
        ]);
        return redirect('/moderator/exam-category');
    }

    public function categoryDestroy(ExamCategory $category)
    {
        abort(403,'Access Denied. Please Contact Admin.');
        $category->delete();
        return redirect('/moderator/exam-category');
    }

    public function categoryExams(ExamCategory $category)
    {
        $data['category'] = $category;
        $data['exams'] = $category->exams;
        return view('moderator.exams.category.exams',$data);
    }

    public function categoryGetExams(ExamCategory $category)
    {
        $exams = $category->exams()->where('status','=','Active')->get();
        return $exams;
    }

    public function examIndex()
    {
        $user = auth()->user();
        // $data['exams'] = Exam::where('user_id','=',$user->id)->get(['id','category_id','name','exam_time','status']);
        $data['exams'] = Exam::get(['id','user_id','category_id','name','exam_time','status']);
        return view('moderator.exams.exam.index',$data);
    }

    public function examCreate()
    {
        $user = auth()->user();
        // $data['categories'] = ExamCategory::where('user_id','=',$user->id)->get(['id','title']);
        $data['categories'] = ExamCategory::get(['id','title']);
        return view('moderator.exams.exam.create',$data);
    }

    public function examStore(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name'=>'required|string',
            'description'=>'string|nullable',
            'date'=>'date|nullable',
            'time'=>'string|nullable',
            'marks'=>'string|nullable',
            'negativeMarks'=>'string|nullable',
            'status'=>'string|nullable',
            'category'=>'numeric|required',
            'answer_video' => 'string|nullable',
            "answer_pdf" => "file|nullable|mimes:pdf",
        ]);

        $pdf_file = '';
        if(isset($request['answer_pdf']))
        {
            $pdf_file= $request->answer_pdf->store('uploads/exam_solution_pdf','public');
        }

        $exam= Exam::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'exam_date'=>$request->date,
            'exam_time'=>$request->time,
            'marks_per_question'=>$request->marks ?? '1',
            'negative_marks'=>$request->negativeMarks ?? '0',
            'status'=>$request->status,
            'category_id'=>$request->category,
            'user_id'=>auth()->user()->id,
            'answer_video' => $request->answer_video,
            'answer_pdf' => $pdf_file,
        ]);

        return redirect('/moderator/exam-category/'.$exam->category_id.'/exams')->with('success','Data Added successfully');

    }

    public function examShow(Exam $exam)
    {
        $data['exam'] = $exam;
        return view('moderator.exams.exam.show',$data);
    }

    public function examEdit(Exam $exam)
    {
        $user = auth()->user();
        // $data['categories'] = ExamCategory::where('user_id','=',$user->id)->get(['id','title']);
        $data['categories'] = ExamCategory::get(['id','title']);
        $data['exam'] = $exam;
        return view('moderator.exams.exam.edit',$data);
    }

    public function examUpdate(Request $request, Exam $exam)
    {
        // dd($request->all());
        $request->validate([
            'name'=>'required|string',
            'description'=>'string|nullable',
            'date'=>'date|nullable',
            'time'=>'string|nullable',
            'marks'=>'string|nullable',
            'negativeMarks'=>'string|nullable',
            'status'=>'string|nullable',
            'category'=>'numeric|required',
            'answer_video' => 'string|nullable',
            "answer_pdf" => "file|nullable|mimes:pdf",
            "old_answer_pdf" => "string|nullable",
        ]);

        $pdf_file = $request->old_answer_pdf;
        if(isset($request['answer_pdf']))
        {
            $pdf_file= $request->answer_pdf->store('uploads/exam_solution_pdf','public');
        }

        $exam->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'exam_date'=>$request->date,
            'exam_time'=>$request->time,
            'marks_per_question'=>$request->marks ?? '1',
            'negative_marks'=>$request->negativeMarks ?? '0',
            'status'=>$request->status,
            'category_id'=>$request->category,
            'answer_video' => $request->answer_video,
            'answer_pdf' => $pdf_file,
        ]);

        return redirect('/moderator/exam-category/'.$exam->category->id.'/exams')->with('success','Data Updated Successfully');
  
    }

    public function examDestroy(Exam $exam)
    {
        abort(403,'Access Denied. Please Contact Admin');
        $exam->openExams()->delete();
        $exam->batchExams()->delete();
        $exam->questions()->delete();
        $exam->results()->delete();
        $exam->evaluations()->delete();
        $exam->delete();
        return redirect('/moderator/exams')->with('success','Data Deleted Successfuly');
   
    }

    public function questionIndex(Exam $exam)
    {
        $data['exam'] = $exam;
        return view('moderator.exams.questions.index',$data);
    }

    public function questionCreate(Exam $exam)
    {
        $data['exam'] = $exam;
        return view('moderator.exams.questions.create',$data);
    }

    public function questionStore(Request $request, Exam $exam)
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
    
            return redirect('/moderator/exams/'.$exam->id.'/questions')->with('success','Data Saved Successfully');    
        }
        else
        {
          return back()->withInput()->withErrors(['optionCorrect' => 'Please use English Alphabets(A,B,C,D) only.']);  
        }

    }

    public function questionShow(Exam $exam, Question $question)
    {
        $data['exam'] = $exam;
        $data['question'] = $question;
        return view('moderator.exams.questions.show',$data);
    }

    public function questionEdit(Exam $exam, Question $question)
    {
        $data['exam'] = $exam;
        $data['question'] = $question;
        return view('moderator.exams.questions.edit',$data);
    }

    public function questionUpdate(Request $request, Exam $exam, Question $question)
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

        return redirect('/moderator/exams/'.$exam->id.'/questions')->with('success','Data Updated Successfully');

    }

    public function questionDestroy(Exam $exam, Question $question)
    {
        $question->delete();
        return redirect('/moderator/exams/'.$exam->id.'/questions')->with('success','Data Deleated Successfully');
    }

    public function questionUpload(Exam $exam)
    {
        $data['exam'] = $exam;
        return view('moderator.exams.questions.upload',$data);
    }

    public function questionImport(Request $request, Exam $exam)
    {
        $request->validate([
            'file'=>'required',
        ]);
        Excel::import(new ExamQuestionsImport($exam),request()->file('file'));
        return redirect('/moderator/exams/'.$exam->id.'/questions');

    }

    public function questionDownload(Request $request, Exam $exam)
    {
        $symbols = array("~"," ", "!", "@", "#", "$", "%", "^", "&", "*", "+", "=", ";", "\"", "<", ">", "/", "|", "`");

        $filename = str_replace($symbols,'_',$exam->name).'_questions.xlsx';
        return Excel::download(new ExamQuestionExport($exam), $filename);
    }

    public function openExamIndex()
    {
        $user = auth()->user();
        // $data['exams'] = OpenExam::where('user_id','=',$user->id)->get();
        $data['exams'] = OpenExam::get();
        return view('moderator.exams.openexams.index',$data);
    }

    public function openExamCreate()
    {
        $user = auth()->user();
        // $data['categories'] = ExamCategory::where('user_id','=',$user->id)->get();
        $data['categories'] = ExamCategory::get();
        return view('moderator.exams.openexams.create',$data);
    }

    public function openExamStore(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'exam_name'=>'required|numeric',
            'status'=>'string|required',
        ]);

        $exam = Exam::find($request->exam_name);
        $slug = Str::slug($exam->name);

        $search = OpenExam::where('exam_id','=',$exam->id)->first(['id','name']);
        if($search)
        {
            return back()->withInput()->withErrors(['exam_name'=>'This Exam is already included in the Open Exams.']);
        }

        OpenExam::create([
            'user_id' => auth()->user()->id,
            'exam_id' => $exam->id,
            'name'=>$exam->name,
            'slug'=>$slug,
            'result_status'=>$request->status ?? 'Unpublished',
        ]);

        return redirect('/moderator/open-exams')->with('success','Data add successfully');

    }

    public function openExamShow(OpenExam $exam)
    {
        $data['exam'] = $exam;
        return view('moderator.exams.openexams.show',$data);
    }

    public function openExamEdit(OpenExam $exam)
    {
        $data['exam'] = $exam;
        return view('moderator.exams.openexams.edit',$data);
    }

    public function openExamUpdate(Request $request, OpenExam $exam)
    {
        // dd($request->all());
        $request->validate([
            'exam'=>'required|string',
            'status'=>'string|required',
            'show_answer' =>'numeric|required|gte:0|lte:1',
        ]);

        $exam->update([
            'result_status'=>$request->status,
            'show_answer'=>$request->show_answer,
        ]);

        return redirect('/moderator/open-exams')->with('success','Data Updated Successfully');
    }

    public function openExamDestroy(OpenExam $exam)
    {
        abort(403,'Access Denied. Please Contact Admin');
        $exam->results()->delete();
        $exam->delete();
        return redirect('/moderator/open-exams')->with('success','Data Deleted Successfuly');
    }

    public function openExamResults(OpenExam $exam)
    {
        $data['exam'] = $exam;
        $data['results'] = $exam->results;
        return view('moderator.exams.openexams.results',$data);
    }

    public function openExamExport(OpenExam $exam): BinaryFileResponse
    {
        $symbols = array("~"," ", "!", "@", "#", "$", "%", "^", "&", "*", "+", "=", ";", "\"", "<", ">", "/", "|", "`");

        $filename = str_replace($symbols,'_',$exam->name).'_applications.xlsx';
        return Excel::download(new OpenExamResultExport($exam), $filename);
    }

}
