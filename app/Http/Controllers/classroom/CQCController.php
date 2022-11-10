<?php

namespace App\Http\Controllers\classroom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\ClassSchedule;
use App\Models\BatchCQC;

class CQCController extends Controller
{
    public function index(Batch $batch)
    {
        if(auth()->user()->role=='Admin'){
            $header='admin.layouts.app';
        }elseif (auth()->user()->role=='Student'){
            $header='student.layouts.app';
        }elseif (auth()->user()->role=='Tutor'){
            $header='tutors.layouts.app';
        }else{
            $header='layouts.app';
        }
        $todaytime=ClassSchedule::where('batch_id','=',$batch->id)->whereDate('date','=',date('Y-m-d'))->first();
        $cqcs=$batch->cqcs;
        return view('classroom.cqc',compact('batch','todaytime','cqcs','header'));
    }

    public function store(Request $request, Batch $batch)
    {
        $request->validate(['question'=>'string|required|min:8']);
        $batch->cqcs()->create([
            'name'=>auth()->user()->name,
            'question'=>$request->question,
        ]);
        return redirect('/classroom/cqcs/'.$batch->id);
    }

    public function destroy(Request $request, Batch $batch, BatchCQC $question)
    {
        // dd($question);
        $question->delete();
        return redirect('/classroom/cqcs/'.$batch->id);
    }
}
