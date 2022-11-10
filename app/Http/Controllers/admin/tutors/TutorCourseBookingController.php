<?php

namespace App\Http\Controllers\admin\tutors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tutor;
use App\Models\Tutors\SpecialCourse;
use App\Models\Tutors\SpecialCourseBooking;

class TutorCourseBookingController extends Controller
{
    public function index(Tutor $tutor,SpecialCourse $course)
    {
        $bookings=$course->bookings()->get();
        return view('admin.tutors.courses.bookings.index',compact('bookings','tutor','course'));
    }

    public function show(Tutor $tutor,SpecialCourse $course, SpecialCourseBooking $booking)
    {
        return view('admin.tutors.courses.bookings.show',compact('booking','tutor','course'));
    }

    public function edit(Tutor $tutor,SpecialCourse $course, SpecialCourseBooking $booking)
    {
        return view('admin.tutors.courses.bookings.edit',compact('booking','tutor','course'));
    }

    public function update(Request $request, Tutor $tutor,SpecialCourse $course, SpecialCourseBooking $booking)
    {
        // dd($request->all());
        $data=request()->validate([
            'status'=>'string | required | min:1',
            'uploadDocument'=>'image|nullable',
            'oldDocument'=>'',
            'paymentAmount'=>'required|numeric',
            'verificationMode'=>'min:1',
            'accountNo'=>'',
            'coursefee'=>'required|numeric',
        ]);
        $img=$data['oldDocument'];
        if(isset($data['uploadDocument']))
        {
            $img=request('uploadDocument')->store('uploads','public');
        }
        $due=(integer)($data['coursefee']-$data['paymentAmount']);
        $booking->update([
            'status'=>$data['status'],
            'paymentAmount'=>$data['paymentAmount'],
            'verificationDocument'=>$img,
            'verificationMode'=>$data['verificationMode'] ?? '',
            'accountNo'=>$data['accountNo'] ?? '',
            'updatedBy'=>auth()->user()->name,
            'dueAmount'=>$due,
        ]);
        return redirect('/admin/tutors/'.$tutor->id.'/courses/'.$course->id.'/bookings');
    }

    public function destroy(Request $request, Tutor $tutor,SpecialCourse $course, SpecialCourseBooking $booking)
    {
        $booking->delete();
        return redirect('/admin/tutors/'.$tutor->id.'/courses/'.$course->id.'/bookings');
    }

}
