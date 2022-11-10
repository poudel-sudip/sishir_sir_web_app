<?php

namespace App\Http\Controllers\admin\Exams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Exams\WrittenExam;
use App\Models\Exams\WrittenExamSolution;

class WrittenExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Batch $batch)
    {
        $exams=$batch->writtenExams()->get();
        return view('admin.exams.batch.writtenexamlist',compact('exams','batch'));
        // dd($exams);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Batch $batch)
    {
        return view('admin.exams.batch.writtenexamcreate',compact('batch'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Batch $batch)
    {
        // dd($request->all());
        $request->validate([
            'question'=>'required|string|min:3'
        ]);

        $batch->writtenExams()->create([
            'question'=>$request->question
        ]);

        return redirect('/admin/batches/'.$batch->id.'/written-exams');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Batch $batch, WrittenExam $exam)
    {
        $exam->delete();
        return redirect('/admin/batches/'.$batch->id.'/written-exams');
    }

    public function solutions(Batch $batch, WrittenExam $exam)
    {
        $results=$exam->solutions;
        return view('admin.exams.batch.writtenexamresults',compact('batch','exam','results'));
    }

    public function solutionview(Batch $batch, WrittenExam $exam, WrittenExamSolution $solution)
    {
        // dd($solution);
        return view('admin.exams.batch.questionsolution',compact('batch','exam','solution'));
    }

    public function remarks(Request $request, Batch $batch, WrittenExam $exam, WrittenExamSolution $solution)
    {
        // dd($solution,$request->all());
        $request->validate([
            'remarks'=>'required|string'
        ]);
        $solution->update([
            'remarks'=>$request->remarks
        ]);

        return redirect('/admin/batches/'.$batch->id.'/written-exams/'.$exam->id.'/solutions/'.$solution->id);
    }

}
