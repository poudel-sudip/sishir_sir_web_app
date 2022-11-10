<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Assignments\Assignment;
use App\Models\Assignments\AssignmentAnswer;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Batch $batch)
    {
        $assignments=$batch->assignments()->get();
        return view('admin.batches.assignments.index',compact('assignments','batch'));
        // dd($assignments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Batch $batch)
    {
        return view('admin.batches.assignments.create',compact('batch'));
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

        $batch->assignments()->create([
            'question'=>$request->question
        ]);

        return redirect('/admin/batches/'.$batch->id.'/assignments');
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
    public function destroy(Batch $batch, Assignment $assignment)
    {
        // dd($assignment);
        $assignment->delete();
        return redirect('/admin/batches/'.$batch->id.'/assignments');
    }

    public function answers(Batch $batch, Assignment $assignment)
    {
        $answers=$assignment->answers;
        return view('admin.batches.assignments.answers',compact('batch','assignment','answers'));
    }

    public function answerview(Batch $batch, Assignment $assignment, AssignmentAnswer $answer)
    {
        // dd($batch,$assignment,$answer);
        return view('admin.batches.assignments.answerview',compact('batch','assignment','answer'));
    }

    public function remarks(Request $request, Batch $batch, Assignment $assignment, AssignmentAnswer $answer)
    {
        // dd($answer,$request->all());
        $request->validate([
            'remarks'=>'required|string'
        ]);
        $answer->update([
            'remarks'=>$request->remarks
        ]);

        return redirect('/admin/batches/'.$batch->id.'/assignments/'.$assignment->id.'/answers/');

    }
}
