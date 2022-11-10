<?php

namespace App\Http\Controllers\classroom\TutorCourse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tutors\SpecialCourse;

class ChatController extends Controller
{
    public function index(SpecialCourse $course)
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

        $bookings=$course->bookings()->where('status','=','Verified')->get();
        $students=[];
        foreach ($bookings as $booking)
        {
            $students[] = (object)['name'=>$booking->user->name];
        }
        return view('specialCourseClassroom.chat',compact('course','header','students'));
        // dd($course,$students);
    }


    public function store(SpecialCourse $course)
    {
        $data=request()->validate([
            'message'=>'string | required',
            'to'=>'required | string',
        ]);
        $from=auth()->user()->name;
        if(auth()->user()->role=='Admin')
        {
            $from='Admin';
        }
        if(auth()->user()->role=='Tutor')
        {
            $from=$from.'(Tutor)';
        }
        $course->chats()->create([
            'from'=>$from,
            'to'=>$data['to'],
            'message'=>$data['message'],
        ]);
        return redirect('/special-course/classroom/chat/'.$course->id);
    }
    
}
