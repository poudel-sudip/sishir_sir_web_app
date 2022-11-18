<?php

namespace App\Http\Controllers\Admin\Exams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exams\Exam;
use App\Models\Exams\Question;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExamQuestionsImport;
class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Exam $exam)
    {
        return view('admin.exams.questions.questionlist',compact('exam'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Exam $exam)
    {
        return view('admin.exams.questions.questioncreate',compact('exam'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Exam $exam)
    {
        $request->validate([
            'question'=>'required|string|min:5',
            'optionA'=>'required|string',
            'optionB'=>'required|string',
            'optionC'=>'string|nullable',
            'optionD'=>'string|nullable',
            'optionCorrect'=>'required|string|max:1',
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
            ]);
    
            return redirect('/admin/exams/'.$exam->id.'/questions')->with('success','Data Saved Successfully');    
        }
        else
        {
          return back()->withInput()->withErrors(['optionCorrect' => 'Please use English Alphabets(A,B,C,D) only.']);  
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam, Question $question)
    {
        return view('admin.exams.questions.questionedit',compact('exam','question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam, Question $question)
    {
        $request->validate([
            'question'=>'required|string|min:5',
            'optionA'=>'required|string',
            'optionB'=>'required|string',
            'optionC'=>'string|nullable',
            'optionD'=>'string|nullable',
            'optionCorrect'=>'required|string|max:1',
        ]);
        // dd($request->all());

        $question->update([
            'name'=>$request->question,
            'opt_a'=>$request->optionA,
            'opt_b'=>$request->optionB,
            'opt_c'=>$request->optionC,
            'opt_d'=>$request->optionD,
            'opt_correct'=>strtoupper($request->optionCorrect),
        ]);

        return redirect('/admin/exams/'.$exam->id.'/questions')->with('success','Data Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

}
