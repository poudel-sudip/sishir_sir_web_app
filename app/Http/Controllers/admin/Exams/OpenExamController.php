<?php

namespace App\Http\Controllers\Admin\Exams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OpenExams\OpenExam;
use Illuminate\Support\Str;
use App\Models\Exams\Exam;
use App\Models\Exams\ExamCategory;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Exams\OpenExamResultExport;

class OpenExamController extends Controller
{
    public function index()
    {
        $exams=OpenExam::all();
        return view('admin.exams.openexams.examslist',compact('exams'));
    }

    public function create()
    {
        $categories = ExamCategory::all();
        return view('admin.exams.openexams.examcreate',compact('categories'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'exam_name'=>'required|numeric',
            'status'=>'string|required',
            'image' => 'nullable|image',
        ]);

        $exam = Exam::find($request->exam_name);
        $slug = Str::slug($exam->name);

        $search = OpenExam::where('exam_id','=',$exam->id)->first(['id','name']);
        if($search)
        {
            return back()->withInput()->withErrors(['exam_name'=>'This Exam is already included in the Open Exams.']);
        }

        $thumbnail = null;
        if(isset($request->image))
        {
            $thumbnail = $request->image->store('uploads','public');
        }
        
        OpenExam::create([
            'exam_id' => $exam->id,
            'name'=>$exam->name,
            'slug'=>$slug,
            'result_status'=>$request->status ?? 'Unpublished',
            'image' => $thumbnail,
        ]);

        return redirect('/admin/open-exams')->with('success','Data add successfully');

    }

    public function show(OpenExam $exam)
    {
        return view('admin.exams.openexams.examshow',compact('exam'));
    }

    public function edit(OpenExam $exam)
    {
        return view('admin.exams.openexams.examedit',compact('exam'));
    }

    public function update(Request $request, OpenExam $exam)
    {
        // dd($request->all());
        $request->validate([
            'exam'=>'required|string',
            'status'=>'string|required',
            'image' => 'nullable|image',
            'oldImage' =>'string|nullable',
        ]);

        $thumbnail = $request->oldImage;
        if(isset($request->image))
        {
            $thumbnail = $request->image->store('uploads','public');
        }

        $exam->update([
            'result_status'=>$request->status,
            'image' => $thumbnail,
        ]);

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
        return view('admin.exams.openexams.examresults',compact('exam','results'));
    }

    public function export(OpenExam $exam): BinaryFileResponse
    {
        $fileName = $exam->slug.'-applications.xlsx';
        return Excel::download(new OpenExamResultExport($exam), $fileName);
    }

    public function deleteDublicate(OpenExam $exam)
    {       
        $duplicate_contact = $exam->results()->select('contact')->groupBy('contact')
        ->havingRaw('COUNT(*) > 1')
        ->pluck('contact')
        ->toArray();

        $duplicates = [];
        foreach ($duplicate_contact as $contact) {
            $duplicates[] = $exam->results()
            ->where('contact', $contact)
            ->orderByDesc('id')            
            ->get(['id','contact'])
            ->slice(1)
            ->pluck('id')
            ->toArray();
        }
        
        $duplicates = array_merge(...$duplicates);
        $dublicateEntry = $exam->results()->whereIn('id',$duplicates)->delete();

        // dd($dublicateEntry);

        return redirect('/admin/open-exams/'.$exam->id.'/results');

    }
}
