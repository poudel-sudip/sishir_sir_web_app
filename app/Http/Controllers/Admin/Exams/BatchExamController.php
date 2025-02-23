<?php

namespace App\Http\Controllers\Admin\Exams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Exams\BatchExam;
use App\Models\Exams\Exam;
use App\Models\Exams\ExamCategory;

class BatchExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Batch $batch)
    {
        $exams=$batch->batchExams;
        return view('admin.exams.batch.examlist',compact('batch','exams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Batch $batch)
    {
        $categories = ExamCategory::all();
        return view('admin.exams.batch.associatebatchexam',compact('categories','batch'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Batch $batch)
    {
        // dd($request->all());
        $request->validate([
            'exam_name'=>'required|numeric|min:1',
        ]);
        $batch->batchExams()->create([
            'exam_id'=>$request->exam_name,
        ]);

        return redirect('/admin/batches/'.$batch->id.'/exams');
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
    public function destroy(Batch $batch, BatchExam $exam)
    {
        $results=$exam->exam->results()->where('batch_id','=',$batch->id);
        $evaluations=$exam->exam->evaluations()->where('batch_id','=',$batch->id);
        // dd($results,$evaluations);
        $results->delete();
        $evaluations->delete();
        $exam->delete();
        return redirect('/admin/batches/'.$batch->id.'/exams');
    }

    public function results(Batch $batch,Exam $exam)
    {
        // $results=[];
        $results=$batch->results;
        return view('admin.exams.batch.examresults',compact('batch','exam','results'));
    }
}
