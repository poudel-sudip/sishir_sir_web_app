<?php

namespace App\Http\Controllers\Tutors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tutors\TutorCoursePayment;
use App\Models\Tutors\SpecialCourse;

class TutorCoursePaymentController extends Controller
{
    public function index()
    {
        $payments=auth()->user()->tutorProfile->paymentRequests;
        return view('tutors.payments.index',compact('payments'));
        // dd($payments);
    }

    public function request()
    {
        $tutor=auth()->user()->tutorProfile;
        $courses=$tutor->specialCourses()->where('paid_status','!=','Paid')->get();
        // dd($courses);
        return view('tutors.payments.request',compact('tutor','courses'));
    }

    public function create(SpecialCourse $course)
    {
        $totalPayAmount=0;
        $paidAmount= (integer) auth()->user()->tutorProfile->paymentRequests()->where('course_id','=',$course->id)->sum('amount') ?? 0;
        // dd($course);
        if($course->payMode == 'Percentage')
        {
            $collectedAmount= (integer) $course->bookings()->where('status','=','Verified')->sum('paymentAmount') ?? 0;
            $totalPayAmount= (integer)(($collectedAmount/100) * ((integer)$course->payAmount));
        }
        elseif($course->payMode == 'Package')
        {
            $totalPayAmount=$course->payAmount;
        }
        elseif($course->payMode == 'Daywise')
        {
            $totalPayAmount= ((integer)$course->payAmount) * ((integer)$course->worked_days);
        }
        else{}
        // dd($course,$totalPayAmount,$paidAmount);
        return view('tutors.payments.create',compact('course','totalPayAmount','paidAmount'));
    }

    public function  store(Request $request)
    {
        if($request->requestAmount > $request->remainingAmount)
        {
            return redirect()->back()->withErrors(['requestAmount' => 'The Requested Amount should be less than Remaining Amount'])->withInput();
        }
        // dd($request->all());
        TutorCoursePayment::create([
            'tutor_id'=>auth()->user()->tutorProfile->id,
            'course_id'=>$request->course,
            'courseType'=>'Special',
            'amount'=>$request->requestAmount,
            'status'=>'Unpaid',
            'remarks'=>$request->remarks,
        ]);

        return redirect('/tutor/payment-requests');
    }
}
