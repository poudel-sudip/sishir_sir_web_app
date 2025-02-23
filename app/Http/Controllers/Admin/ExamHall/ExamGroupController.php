<?php

namespace App\Http\Controllers\Admin\ExamHall;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;

class ExamGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function groupIndex()
    {  
        $data['groups'] = Categories::where('type','=','exam_hall')->get();
        return view('admin.examhall.group.index',$data);
    }

    public function groupCreate()
    {
        return view('admin.examhall.group.create');
    }

    public function groupStore()
    {
        $data = request()->validate([
            'name'=>'required | string',
            'order'=>'required | numeric',
            'status'=>'required',
        ]);
        Categories::create([
            'type' => 'exam_hall',
            'name'=>$data['name'],
            'status'=>$data['status'],
            'order'=>$data['order'],
        ]);
        return redirect('/admin/exam-hall/groups');
    }  

    public function groupEdit(Categories $group)
    {
        $data['group'] = $group;
        return view('admin.examhall.group.edit',$data);
    }

    public function groupUpdate(Categories $group, Request $request)
    {
       $data = $request->validate([
            'name'=>'required | string',
            'order'=>'required | numeric',
            'status'=>'required',
        ]);
        $group->update([
            'name'=>$data['name'],
            'status'=>$data['status'],
            'order'=>$data['order'],
        ]);
        return redirect('/admin/exam-hall/groups');
    }

    public function groupDestroy(Categories $group)
    {
        $group->delete();
        return redirect('/admin/exam-hall/groups');
    }

    public function groupExamSets(Categories $group)
    {
        $data['exam_sets'] = $group->premium_exams;
        $data['group'] = $group;
        return view('admin.examhall.group.exam_sets',$data);
    }

}
