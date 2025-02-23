<?php

namespace App\Http\Controllers\Admin\Courses;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class BatchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.batches.index',[
            'batches'=>Batch::all(),
        ]);
    }

    public function create()
    {
        return view ('admin.batches.create',[
            'courses'=>Course::all()->where('status','=','Active'),
        ]);
    }

    public function store()
    {
        $data=request()->validate([
            'course'=>'integer | required | min:1',
            'name'=>'string | required',
            'description'=>'string',
            'fee'=>'integer | required',
            'discount'=>'integer | required',
            'duration'=>'integer | nullable',
            'durationType'=>'string | nullable',
            'startDate'=>'date | nullable',
            'endDate'=>'date | nullable',
            'timeSlot'=>'string|nullable',
            'classroomLink'=>'string|nullable',
            'status'=>'string|nullable',
        ]);
        Batch::create([
            'course_id'=>$data['course'],
            'name'=>$data['name'],
            'description'=>$data['description'],
            'fee'=>$data['fee'],
            'discount'=>$data['discount'],
            'duration'=>$data['duration'],
            'durationType'=>$data['durationType'],
            'startDate'=>$data['startDate'],
            'endDate'=>$data['endDate'],
            'timeSlot'=>$data['timeSlot'] ?? '',
            'classroomLink'=>$data['classroomLink'],
            'status'=>$data['status'],
        ]);
        return redirect('/admin/batches');
    }

    public function show(Batch $batch)
    {
        return view('admin.batches.show',compact('batch'));
    }

    public function edit(Batch $batch)
    {
        $courses=Course::all()->where('status','=','Active');
        return view ('admin.batches.edit', compact('courses','batch'));
    }

    public function update(Batch $batch)
    {
        // dd(request()->all());
        $data=request()->validate([
            'course'=>'integer | required | min:1',
            'name'=>'string | required',
            'description'=>'string',
            'fee'=>'integer | required',
            'discount'=>'integer | required',
            'duration'=>'integer | required',
            'durationType'=>'string',
            'startDate'=>'date',
            'endDate'=>'date',
            'timeSlot'=>'string|nullable',
            'classroomLink'=>'',
            'class_status'=>'',
            'status'=>'',
            'isPinned' =>'string|nullable',
        ]);
        $batch->update([
            'course_id'=>$data['course'],
            'name'=>$data['name'],
            'description'=>$data['description'],
            'fee'=>$data['fee'],
            'discount'=>$data['discount'],
            'duration'=>$data['duration'],
            'durationType'=>$data['durationType'],
            'startDate'=>$data['startDate'],
            'endDate'=>$data['endDate'],
            'timeSlot'=>$data['timeSlot'] ?? '',
            'classroomLink'=>$data['classroomLink'],
            'class_status'=>$data['class_status'],
            'status'=>$data['status'],
            'isPinned'=>$data['isPinned'],
        ]);
        return redirect('/admin/batches');
    }

    public function destroy(Batch $batch)
    {
        $batch->bookings()->delete();
        $batch->delete();
        return redirect('/admin/batches');
    }
}
