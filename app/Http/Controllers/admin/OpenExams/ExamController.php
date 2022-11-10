<?php

namespace App\Http\Controllers\admin\OpenExams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OpenExams\OpenExam;
use Illuminate\Support\Str;
use App\Models\Exams\Exam;
use App\Models\Exams\ExamCategory;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Exams\OpenExamResultExport;

class ExamController extends Controller
{
    public function index()
    {
        $exams=OpenExam::all();
        return view('admin.openexams.examslist',compact('exams'));
    }

    public function create()
    {
        $categories = ExamCategory::all();
        return view('admin.openexams.examcreate',compact('categories'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'exam_name'=>'required|numeric',
            'status'=>'string|required',
        ]);

        $exam = Exam::find($request->exam_name);
        $slug = Str::slug($exam->name);

        OpenExam::create([
            'exam_id' => $exam->id,
            'name'=>$exam->name,
            'slug'=>$slug,
            'result_status'=>$request->status ?? 'Unpublished',
        ]);

        return redirect('/admin/open-exams')->with('success','Data add successfully');

    }

    public function show(OpenExam $exam)
    {
        return view('admin.openexams.examshow',compact('exam'));
    }

    public function edit(OpenExam $exam)
    {
        return view('admin.openexams.examedit',compact('exam'));
    }

    public function update(Request $request, OpenExam $exam)
    {
        // dd($request->all());
        $request->validate([
            'exam'=>'required|string',
            'status'=>'string|required',
        ]);

        $exam->update(['result_status'=>$request->status]);

        return redirect('/admin/open-exams')->with('success','Data Updated Successfully');
  
    }

    public function destroy(OpenExam $exam)
    {
        $exam->results()->delete();
        $exam->delete();
        return redirect('/admin/open-exams')->with('success','Data Deleted Successfuly');
   
    }

    public function results(OpenExam $exam)
    {
        $results=$exam->results;
        return view('admin.openexams.examresults',compact('exam','results'));
    }

    public function export(OpenExam $exam): BinaryFileResponse
    {
        $fileName = $exam->slug.'-applications.xlsx';
        return Excel::download(new OpenExamResultExport($exam), $fileName);
    }
}
