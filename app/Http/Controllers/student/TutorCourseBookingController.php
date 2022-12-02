<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tutor;
use App\Models\Tutors\SpecialCourseBooking;

class TutorCourseBookingController extends Controller
{
   public function index()
   {
      $bookings=auth()->user()->specialCourseBookings;
      return view('student.specialCourse.index',compact('bookings'));
   }

   public function enroll()
   {
      $tutors=Tutor::all()->reject(function($tutor)
      {
         $count= $tutor->specialCourses()->where('status','=','Active')->count();
         if($count==0)
         {
            return $tutor;
         }
      });
      
      return view('student.specialCourse.enroll',compact('tutors'));
   }

   public function store(Request $request)
   {
      // dd($request->all());
      $request->validate([
         'tutor_name'=>'numeric|required',
         'course_name'=>'numeric|required',
      ]);
      $search=SpecialCourseBooking::where([
         ['course_id','=',$request->course_name],
         ['user_id','=',auth()->user()->id],
         ])->count();
      if($search){
            return back()->withInput()->with('alreadybooked', 'You Have Already Booked This Course!');
      }
      $booking = SpecialCourseBooking::create([
         'course_id'=>$request->course_name,
         'user_id'=>auth()->user()->id,
         'user_name'=>auth()->user()->name,
         'status'=>'Unverified',
      ]);
      // dd($booking);
      // return redirect('/student/tutor-special/courses');
      return redirect('/student/tutor-special/courses/'.$booking->id.'/edit');
   }

   public function show(SpecialCourseBooking $booking)
   {
      return view('student.specialCourse.show',compact('booking'));
   }
 
   public function edit(SpecialCourseBooking $booking)
   {
      return view('student.specialCourse.verify',compact('booking'));
   }

   public function verify(SpecialCourseBooking $booking)
   {
      // dd(request()->all());
      $data=request()->validate([
         'verificationMode'=>'required | string',
         'accountNo'=>'required',
         'paymentAmount'=>'required | integer',
         'verificationDocument'=>'required | image',
     ]);
     $imagePath=request('verificationDocument')->store('uploads','public');

     $booking->update([
         'verificationMode'=>$data['verificationMode'],
         'accountNo'=>$data['accountNo'],
         'paymentAmount'=>$data['paymentAmount'],
         'verificationDocument'=>$imagePath,
         'status'=>'Processing',
     ]);
     return redirect('/student/tutor-special/courses');
   }

}
