<?php

namespace App\Http\Controllers\Admin\Exams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exams\Exam;
use App\Models\Exams\ExamCategory;
use App\Models\Exams\ExamCQC;
use App\Models\User;
use App\Models\ExamHall\ExamHallExams;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exams=Exam::all();
        return view('admin.exams.examslist',compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ExamCategory::all();
        return view('admin.exams.examcreate',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
            "pdf_view" => "required|numeric|gte:0|lte:1",
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
            'answer_video' => $request->answer_video,
            'answer_pdf' => $pdf_file,
            'pdf_view' => $request->pdf_view,
        ]);

        return redirect('/admin/exam-category/'.$exam->category_id.'/exams')->with('success','Data add successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        return view('admin.exams.examshow',compact('exam'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        $data['exam'] = $exam;
        $data['categories'] = ExamCategory::all();
        $data['creators'] = User::where('role','=','Moderator')->where('status','=','Active')->get(['id','name']);

        
        // dd($data);
        return view('admin.exams.examedit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
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
            'creator'=>'numeric|nullable',
            "answer_pdf" => "file|nullable|mimes:pdf",
            "old_answer_pdf" => "string|nullable",
            "pdf_view" => "required|numeric|gte:0|lte:1",
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
            'user_id'=>$request->creator,
            'answer_pdf' => $pdf_file,
            'pdf_view' => $request->pdf_view,
        ]);

        return redirect('/admin/exam-category/'.$exam->category->id.'/exams')->with('success','Data Updated Successfully');
  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {

        ExamHallExams::where('exam_id','=',$exam->id)->delete();
        $exam->openExams()->delete();
        $exam->batchExams()->delete();
        $exam->questions()->delete();
        $exam->results()->delete();
        $exam->evaluations()->delete();
        $exam->cqcs()->delete();
        $exam->delete();

        // return redirect('/admin/exams')->with('success','Data Deleted Successfuly');
        return redirect()->back()->with('success','Data Deleted Successfuly');
   
    }


    public function indexCqc(Exam $exam, Request $request)
    {
        $data['exam'] = $exam;
        $data['cqcs'] = $exam->cqcs()->orderByDesc('id')->paginate(15);
        
        $exam->cqc_unread()->update([
            'read' => 1,
        ]);

        // dd($data);
        return view('admin.exams.cqc.index',$data);
    }

    public function createCqc(Exam $exam, Request $request)
    {
        $data['exam'] = $exam;
        
        // dd($data);
        return view('admin.exams.cqc.create',$data);
    }

    public function storeCqc(Exam $exam, Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $exam->cqcs()->create([
            'title' => $request->title,
            'description' => $request->description,
            'read' => 1,
            'user_id' => auth()->user()->id,
        ]);
        
        return redirect('/admin/exams/'.$exam->id.'/cqcs');
    }

    public function editCqc(Exam $exam, ExamCQC $cqc, Request $request)
    {
        $data['exam'] = $exam;
        $data['cqc'] = $cqc;
        
        // dd($data);
        return view('admin.exams.cqc.edit',$data);
        
    }

    public function updateCqc(Exam $exam, ExamCQC $cqc, Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $cqc->update([
            'title' => $request->title,
            'description' => $request->description,
            'read' => 1,
        ]);

        return redirect('/admin/exams/'.$exam->id.'/cqcs');
    }

    public function destroyCqc(Exam $exam, ExamCQC $cqc, Request $request)
    {
       $cqc->delete();

       return redirect('/admin/exams/'.$exam->id.'/cqcs');
    }

}
