<?php

namespace App\Http\Controllers\classroom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\BatchCQC;

class CQCController extends Controller
{
    public function index(Batch $batch)
    {
        if(auth()->user()->role=='Admin'){
            $header='admin.layouts.app';
        }elseif (auth()->user()->role=='Student'){
            $header='student.layouts.app';
        }else{
            $header='layouts.app';
        }
        $cqcs=$batch->cqcs;
        return view('classroom.cqc',compact('batch','cqcs','header'));
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
