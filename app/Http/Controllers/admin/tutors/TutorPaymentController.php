<?php

namespace App\Http\Controllers\admin\tutors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tutor;
use App\Models\Tutors\SpecialCourse;
use App\Models\Tutors\TutorCoursePayment;
use App\Models\Accounts\AccountExpense;

class TutorPaymentController extends Controller
{
    public function index(Tutor $tutor, SpecialCourse $course)
    {
        $payments=$course->payments->sortByDesc('id');
        // dd($tutor,$course,$payments);
        $totalPayAmount=0;
        $paidAmount= (integer) $tutor->paymentRequests()->where('course_id','=',$course->id)->where('status','=','Paid')->sum('amount') ?? 0;
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

        return view('admin.tutors.courses.payments.index',compact('tutor','course','payments','totalPayAmount','paidAmount'));
    }

    public function update(Tutor $tutor, SpecialCourse $course, TutorCoursePayment $pay)
    {
        // dd($tutor,$course,$pay);
        $result=$pay->update([
            'status'=>'Paid',
        ]);

        return redirect('/admin/tutors/'.$tutor->id.'/courses/'.$course->id.'/payments');
    }

}
