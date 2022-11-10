<?php

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Batch;
use App\Models\User;
use App\Models\Booking;
use App\Models\Vendors\VendorBooking;

class CourseBookingController extends Controller
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
            $bookings = $vendor->mybookings()->where('team_id','=',$team->id)->get();
        }
        // dd($bookings);
        return view('teams.bookings.course.allbookings',compact('bookings'));
    }

    public function index()
    {
        $team = auth()->user()->team;
        $vendor = $team->vendor;
        $bookings = [];
        if($vendor)
        {
            $bookings = $vendor->mybookings()->where('team_id','=',$team->id)->get()->sortByDesc('id')->take(300);
        }
        // dd($bookings);
        return view('teams.bookings.course.index',compact('bookings'));
    }

    public function create()
    {
        $courses = Course::where('status','Active')->get();
        return view('teams.bookings.course.create',compact('courses'));
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
            "course_name" => "numeric | required| min:1",
            "batch_name" => "numeric | required| min:1",
            "userID" => "numeric | required| min:1",
            "paymentAmount" => "numeric | required | min:1",
            "discount" => "numeric | nullable",
            "remarks" => "string | nullable",
            "verificationDocument" => "image | nullable",
        ]);

        $batch = Batch::find($request['batch_name']);
        if(!$batch)
        {
            return back()->withInput()->withErrors(['batch_name'=>'Course Batch Mismatch. Please Check Again !!!']);   
        }

        $user = User::find($request['userID']);
        if(!$user)
        {
            return back()->withInput()->withErrors(['userID'=>'Given User ID is Incorrect. Please Check Again !!!']);   
        }

        $search = Booking::where([
            ['course_id','=',$request['course_name']],
            ['batch_id','=',$request['batch_name']],
            ['user_id','=',$request['userID']],
            ])->count();
        if($search){
            return back()->withInput()->withErrors(['batch_name'=>'This Course Batch is Already Booked by the Given User. Please Check Again !!!']);
        }

        $due = (integer)(($batch->fee - $batch->discount) - $request['paymentAmount'] - $request['discount']);
        $img = "";
        if(isset($request['verificationDocument']))
        {
            $img = request('verificationDocument')->store('uploads','public');
        }  

        $booking = Booking::create([
            'course_id'=>$batch->course_id,
            'batch_id'=>$batch->id,
            'user_id'=>$user->id,
            'user_name'=>ucwords($user->name),
            'description'=> 'Manual Booked by Team Member',
            'updatedBy'=>auth()->user()->name,
            'verificationMode'=> 'Manual',
            'paymentAmount'=> $request['paymentAmount'],
            'discount'=> $request['discount'] ?? 0,
            'dueAmount'=> $due,
            'features'=> 'All',
            'status'=>'Processing',
            'verificationDocument'=>$img,
            'remarks' => $request['remarks'],
        ]);

        $vendor->mybookings()->create([
            'booking_id'=>$booking->id,
            'Amount' => $request['paymentAmount'],
            'verificationDocument' => $img,
            'team_id' => $team->id,
        ]);

        return redirect('/team/course-bookings')->with('success_message', 'Course Booking of User with ID '.$user->id.' Created Succesfully.');

    }

    public function show(VendorBooking $vbooking)
    {
        $booking = $vbooking->booking;
        return view('teams.bookings.course.show',compact('booking'));
    }

    public function edit(VendorBooking $vbooking)
    {
        $booking = $vbooking->booking;
        $courses = Course::where('status','Active')->get();
        return view('teams.bookings.course.edit',compact('vbooking','booking','courses'));
    }

    public function update(VendorBooking $vbooking, Request $request)
    {
        // dd($request->all(),$vbooking);
        $request->validate([
            "verificationMode" => "required|string",
            "features" => "required|string",
            "status" => "required|string",
            "remarks" => "nullable|string",
        ]);

        $vbooking->booking()->update([
            'status'=>$request['status'],
            'updatedBy'=>auth()->user()->name,
            'verificationMode'=>$request['verificationMode'],
            'features'=>$request['features'],
            'remarks'=>$request['remarks'],
        ]);

        return redirect('/team/course-bookings')->with('success_message', 'Course Booking with ID '.$vbooking->booking_id.' Updated Succesfully.');
    }

    public function destroy(VendorBooking $vbooking)
    {
        $vbooking->booking()->delete();
        $vbooking->delete();
        return redirect('/team/course-bookings')->with('success_message', 'Course Booking with ID '.$vbooking->booking_id.' Deleted Succesfully.');
    }
}
