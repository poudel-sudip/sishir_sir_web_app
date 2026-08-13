<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OpenExams\OpenExam;
use App\Models\Exams\Exam;
use App\Models\Exams\ExamCQC;

class McqExamcontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function freeExamList(Request $request)
    {
        $data['free_exams'] = OpenExam::where('result_status','=','Unpublished')
        ->get()
        ->sortByDesc('id')
        ->values();

        return view('student.mcq-exam.free.list',$data);
    }


    public function indexCqc(Exam $exam, Request $request)
    {
        $data['exam'] = $exam;
        $data['cqcs'] = $exam->cqcs()->orderByDesc('id')->paginate(15);
        
        // dd($data);
        return view('student.mcq-exam.cqc.index',$data);
    }

    public function createCqc(Exam $exam, Request $request)
    {
        $data['exam'] = $exam;
        
        // dd($data);
        return view('student.mcq-exam.cqc.create',$data);
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
            'user_id' => auth()->user()->id,
        ]);
        
        return redirect('/student/mcq-exams/'.$exam->id.'/cqcs');
    }

    public function editCqc(Exam $exam, ExamCQC $cqc, Request $request)
    {
        if($cqc->user_id != auth()->user()->id)
        {
            abort(403, 'You Are Not Authorized to Edit this Data.');
        }

        $data['exam'] = $exam;
        $data['cqc'] = $cqc;
        
        // dd($data);
        return view('student.mcq-exam.cqc.edit',$data);
        
    }

    public function updateCqc(Exam $exam, ExamCQC $cqc, Request $request)
    {
        if($cqc->user_id != auth()->user()->id)
        {
            abort(403, 'You Are Not Authorized to Edit this Data.');
        }

        // dd($request->all());
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $cqc->update([
            'title' => $request->title,
            'description' => $request->description,
            'read' => 0,
        ]);

        return redirect('/student/mcq-exams/'.$exam->id.'/cqcs');
    }

    public function destroyCqc(Exam $exam, ExamCQC $cqc, Request $request)
    {
        if($cqc->user_id != auth()->user()->id)
        {
            abort(403, 'You Are Not Authorized to Delete this Data.');
        }

       $cqc->delete();

       return redirect('/student/mcq-exams/'.$exam->id.'/cqcs');
    }
}
