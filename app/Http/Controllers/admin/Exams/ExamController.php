<?php

namespace App\Http\Controllers\Admin\Exams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exams\Exam;
use App\Models\Exams\ExamCategory;

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
        ]);

        $exam= Exam::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'exam_date'=>$request->date,
            'exam_time'=>$request->time,
            'marks_per_question'=>$request->marks ?? '1',
            'negative_marks'=>$request->negativeMarks ?? '0',
            'status'=>$request->status,
            'category_id'=>$request->category,
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
        $categories = ExamCategory::all();
        return view('admin.exams.examedit',compact('exam','categories'));
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
        ]);

        $exam->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'exam_date'=>$request->date,
            'exam_time'=>$request->time,
            'marks_per_question'=>$request->marks ?? '1',
            'negative_marks'=>$request->negativeMarks ?? '0',
            'status'=>$request->status,
            'category_id'=>$request->category,
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
        $exam->openExams()->delete();
        $exam->batchExams()->delete();
        $exam->questions()->delete();
        $exam->results()->delete();
        $exam->evaluations()->delete();
        $exam->delete();
        return redirect('/admin/exams')->with('success','Data Deleted Successfuly');
   
    }
}
