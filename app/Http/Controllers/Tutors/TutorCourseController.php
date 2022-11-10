<?php

namespace App\Http\Controllers\Tutors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tutors\SpecialCourse;

class TutorCourseController extends Controller
{
    
    public function index()
    {
        $courses=auth()->user()->tutorProfile->specialCourses;
        return view('tutors.course.index',compact('courses'));
    }

    public function create()
    {
        return view('tutors.course.create');
    }

    public function store(Request $request)
    {
        // dd($request->all(),auth()->user()->tutorProfile->id);
        $request->validate([
            'course'=>'string|required',
            'fee'=>'numeric|required',
            'discount'=>'numeric|required',
            'startDate'=>'date|required',
            'duration'=>'string|required',
            'description'=>'string|nullable',
            'payMode'=>'string|required',
            'payAmount'=>'numeric|required',
        ]);
        SpecialCourse::create([
            'tutor_id'=>auth()->user()->tutorProfile->id,
            'course'=>$request->course,
            'fee'=>$request->fee,
            'discount'=>$request->discount,
            'startDate'=>$request->startDate,
            'payMode'=>$request->payMode,
            'payAmount'=>$request->payAmount,
            'description'=>$request->description,
            'duration'=>$request->duration,
            'status'=>'Inactive',
        ]);

        return redirect('/tutor/special-courses');
    }

    public function show(SpecialCourse $course)
    {
        return view('tutors.course.show',compact('course'));
    }

    public function edit(SpecialCourse $course)
    {
        return view('tutors.course.edit',compact('course'));
    }

    public function update(Request $request, SpecialCourse $course)
    {
        // dd($course,$request->all());
        $request->validate([
            'course'=>'string|required',
            'fee'=>'numeric|required',
            'discount'=>'numeric|required',
            'startDate'=>'date|required',
            'duration'=>'string|required',
            'description'=>'string|nullable',
            'payMode'=>'string|required',
            'payAmount'=>'numeric|required',
            'timeSlot'=>'string|required',
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
            'timeSlot'=>$request->timeSlot,
        ]);

        return redirect('/tutor/special-courses');
    }

    public function bookings(SpecialCourse $course)
    {
        $bookings=$course->bookings()->where('status','=','Verified')->get();
        return view('tutors.course.bookings',compact('course','bookings'));
    }

}
