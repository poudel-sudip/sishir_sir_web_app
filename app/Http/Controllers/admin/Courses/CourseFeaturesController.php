<?php

namespace App\Http\Controllers\Admin\Courses;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseFeatures;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CourseFeaturesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Course $course)
    {
        return view('admin.courses.coursefeatures.index',compact('course'));
    }

    public function create(Course $course)
    {
        return view('admin.courses.coursefeatures.create',compact('course'));
    }

    public function store(Course $course)
    {
        $data=request()->validate([
            'course_id'=>'required | min:1',
            'title'=>'required | string',
            'description'=>'required | string',
            'image'=>'required | image',
            'isunique'=>'',
        ]);

        $isunique='No';
        if(isset($data['isunique']))
        {
            $isunique='Yes';
        }

        $imgpath=request('image')->store('uploads','public');

        $course->features()->create([
           'title'=>$data['title'],
           'description'=>$data['description'],
           'image'=>$imgpath,
            'isunique'=>$isunique,
        ]);
        return redirect('/admin/courses/'.$course->id.'/features');
    }

    public function show(Course $course,CourseFeatures $feature)
    {
        return view('admin.courses.coursefeatures.show',compact('feature'));
    }

    public function edit(Course $course, CourseFeatures $feature)
    {
        return view('admin.courses.coursefeatures.edit',compact('feature'));
    }

    public function update(Course $course, CourseFeatures $feature)
    {
        $data=request()->validate([
            'course_id'=>'required | min:1',
            'title'=>'required | string',
            'description'=>'required | string',
            'image'=>'',
            'oldImage'=>'',
            'isunique'=>'',
        ]);

        $isunique='No';
        if(isset($data['isunique']))
        {
            $isunique='Yes';
        }

        $imgpath=$data['oldImage'];
        if(isset($data['image']))
        {
            $imgpath=request('image')->store('uploads','public');
        }
        $feature->update([
            'title'=>$data['title'],
            'description'=>$data['description'],
            'image'=>$imgpath,
            'isunique'=>$isunique,
        ]);
        return redirect('/admin/courses/'.$course->id.'/features');
    }

    public function destroy(Course $course, CourseFeatures $feature)
    {
        $feature->delete();
        return redirect('/admin/courses/'.$course->id.'/features');
    }
}
