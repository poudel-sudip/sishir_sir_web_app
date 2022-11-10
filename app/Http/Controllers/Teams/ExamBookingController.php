<?php

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ExamHall\ExamHallCategories;
use App\Models\ExamHall\ExamHallBookings;
use App\Models\Vendors\VendorExamBooking;

class ExamBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function allBookings()
    {
        $team = auth()->user()->team;
        $vendor = $team->vendor;
        $bookings = [];
        if($vendor)
        {
            $bookings = $vendor->examBookings()->where('team_id','=',$team->id)->get();
        }
        // dd($bookings);
        return view('teams.bookings.exam.index',compact('bookings'));
    }

    public function index()
    {
        $team = auth()->user()->team;
        $vendor = $team->vendor;
        $bookings = [];
        if($vendor)
        {
            $bookings = $vendor->examBookings()->where('team_id','=',$team->id)->get()->sortByDesc('id')->take(300);
        }
        // dd($bookings);
        return view('teams.bookings.exam.index',compact('bookings'));
    }

    public function create()
    {
        $exams = ExamHallCategories::where('status','=','Active')->get();
        return view('teams.bookings.exam.create',compact('exams'));
    }

    public function store(Request $request)
    {
        $team = auth()->user()->team;
        $vendor = $team->vendor;
        if(!$vendor)
        {
            dd("YOU ARE NOT ASSOCIATED WITH A VENDOR OR A BRANCH. PLEASE CONTACT ADMINISTRATOR.");
        }

        $request->validate([
            "exam_name" => "numeric | required| min:1",
            "userID" => "numeric | required| min:1",
            "paymentAmount" => "numeric | required | min:1",
            "discount" => "numeric | nullable",
            "remarks" => "string | nullable",
            "verificationDocument" => "image | nullable",
        ]);

        $user = User::find($request['userID']);
        if(!$user)
        {
            return back()->withInput()->withErrors(['userID'=>'Given User ID is Incorrect. Please Check Again !!!']);   
        }

        $exam = ExamHallCategories::find($request['exam_name']);
        if(!$exam)
        {
            return back()->withInput()->withErrors(['exam_name'=>'Exam Set Mismatch. Please Check Again !!!']);   
        }

        $search = ExamHallBookings::where([
            ['category_id','=',$exam->id],
            ['user_id','=',$user->id],
            ])->count();
        if($search){
            return back()->withInput()->withErrors(['exam_name'=>'This Exam is Already Booked by the Given User. Please Check Again !!!']);
        }

        $due=(integer)($exam->price - $exam->discount  - $request->paymentAmount - $request->discount);
        $img = "";
        if(isset($request['verificationDocument']))
        {
            $img = request('verificationDocument')->store('uploads','public');
        } 

        $booking = ExamHallBookings::create([
            'user_id' => $user->id,
            'category_id' => $exam->id,
            'user_name' => $user->name,
            'status' => 'Processing',
            'remarks' => $request->remarks,
            'updatedBy' =>auth()->user()->name,
            'verificationMode' => 'Manual',
            'paidAmount' => $request['paymentAmount'],
            'discount' => $request['discount'],
            'dueAmount' => $due,
            'verificationDocument'=>$img,
        ]);

        $vendor->examBookings()->create([
            'booking_id'=>$booking->id,
            'Amount' => $request['paymentAmount'],
            'verificationDocument' => $img,
            'team_id' => $team->id,
        ]);

        return redirect('/team/exam-bookings')->with('success_message', 'Exam Set Booking of User with ID '.$user->id.' Created Succesfully.');
    }

    public function show(VendorExamBooking $vbooking)
    {
        $booking = $vbooking->booking;
        return view('teams.bookings.exam.show',compact('booking'));
    }

    public function edit(VendorExamBooking $vbooking)
    {
        $booking = $vbooking->booking;
        $exams = ExamHallCategories::where('status','=','Active')->get();
        return view('teams.bookings.exam.edit',compact('vbooking','booking','exams'));
    }

    public function update(VendorExamBooking $vbooking, Request $request)
    {
        // dd($request->all(),$vbooking);
        $request->validate([
            "verificationMode" => "required|string",
            "status" => "required|string",
            "remarks" => "nullable|string",
        ]);

        $vbooking->booking()->update([
            'status'=>$request['status'],
            'updatedBy'=>auth()->user()->name,
            'verificationMode'=>$request['verificationMode'],
            'remarks'=>$request['remarks'],
        ]);

        return redirect('/team/exam-bookings')->with('success_message', 'Exam Set Booking with ID '.$vbooking->booking_id.' Updated Succesfully.');
    }

    public function destroy(VendorExamBooking $vbooking)
    {
        $vbooking->booking()->delete();
        $vbooking->delete();
        return redirect('/team/exam-bookings')->with('success_message', 'Exam Set Booking with ID '.$vbooking->booking_id.' Deleted Succesfully.');
    }
}
