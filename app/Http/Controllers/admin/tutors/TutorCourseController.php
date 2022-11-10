<?php

namespace App\Http\Controllers\admin\tutors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tutor;
use App\Models\Tutors\SpecialCourse;

class TutorCourseController extends Controller
{
    public function index(Tutor $tutor)
    {
        $courses=$tutor->specialCourses;
        return view('admin.tutors.courses.index',compact('tutor','courses'));
    }

    public function show(Tutor $tutor, SpecialCourse $course)
    {
        return view('admin.tutors.courses.show',compact('tutor','course'));
    }

    public function edit(Tutor $tutor, SpecialCourse $course)
    {
        return view('admin.tutors.courses.edit',compact('tutor','course'));
    }

    public function update(Request $request, Tutor $tutor, SpecialCourse $course)
    {
        // dd($request->all(),$tutor,$course);
        $request->validate([
            'course'=>'string|required',
            'fee'=>'numeric|required',
            'discount'=>'numeric|required',
            'startDate'=>'date|required',
            'duration'=>'string|required',
            'description'=>'string|nullable',
            'payMode'=>'string|required',
            'payAmount'=>'numeric|required',
            'status'=>'required|string|min:1',
            'classroomLink'=>'string|nullable',
            'timeSlot'=>'required|string',
            'workedDays'=>'required|numeric',
        ]);

        $course->update([
            'course'=>$request->course,
            'fee'=>$request->fee,
            'discount'=>$request->discount,
            'startDate'=>$request->startDate,
            'payMode'=>$request->payMode,
            'payAmount'=>$request->payAmount,
            'description'=>$request->description,
            'duration'=>$request->duration,
            'status'=>$request->status,
            'classroomLink'=>$request->classroomLink,
            'timeSlot'=>$request->timeSlot,
            'worked_days'=>$request->workedDays,
        ]);

        return redirect('/admin/tutors/'.$tutor->id.'/courses');
    }

    public function destroy(Request $request, Tutor $tutor, SpecialCourse $course)
    {
        // dd($request->all(),$tutor,$course);
        $course->delete();
        return redirect('/admin/tutors/'.$tutor->id.'/courses');
    }

}
