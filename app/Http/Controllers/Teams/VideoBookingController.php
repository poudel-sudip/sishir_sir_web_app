<?php

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VideoCourse\VideoCourse;
use App\Models\VideoCourse\VideoBooking;
use App\Models\Vendors\VendorVideoBooking;

class VideoBookingController extends Controller
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
            $bookings = $vendor->videoBookings()->where('team_id','=',$team->id)->get();
        }
        // dd($bookings);
        return view('teams.bookings.video.allbookings',compact('bookings'));
    }

    public function index()
    {
        $team = auth()->user()->team;
        $vendor = $team->vendor;
        $bookings = [];
        if($vendor)
        {
            $bookings = $vendor->videoBookings()->where('team_id','=',$team->id)->get()->sortByDesc('id')->take(300);
        }
        // dd($bookings);
        return view('teams.bookings.video.index',compact('bookings'));
    }

    public function create()
    {
        $courses = VideoCourse::where('status','=','Active')->get();
        return view('teams.bookings.video.create',compact('courses'));
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
            "course" => "numeric | required| min:1",
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

        $course = VideoCourse::find($request['course']);
        if(!$course)
        {
            return back()->withInput()->withErrors(['course'=>'Video Course Mismatch. Please Check Again !!!']);   
        }

        $search = VideoBooking::where([
            ['course_id','=',$course->id],
            ['user_id','=',$user->id],
            ])->count();
        if($search){
            return back()->withInput()->withErrors(['course'=>'This Video Course is Already Booked by the Given User. Please Check Again !!!']);
        }

        $due=(integer)($course->fee - $course->discount  - $request->paymentAmount - $request->discount);
        $img = "";
        if(isset($request['verificationDocument']))
        {
            $img = request('verificationDocument')->store('uploads','public');
        } 

        $booking = VideoBooking::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'user_name' => $user->name,
            'status' => 'Processing',
            'remarks' => $request->remarks,
            'updatedBy' =>auth()->user()->name,
            'verificationMode' => 'Manual',
            'paymentAmount' => $request['paymentAmount'],
            'discount' => $request['discount'],
            'dueAmount' => $due,
            'verificationDocument'=>$img,
        ]);

        $vendor->videoBookings()->create([
            'booking_id'=>$booking->id,
            'Amount' => $request['paymentAmount'],
            'verificationDocument' => $img,
            'team_id' => $team->id,
        ]);

        return redirect('/team/video-bookings')->with('success_message', 'Video Course Booking of User with ID '.$user->id.' Created Succesfully.');
    }

    public function show(VendorVideoBooking $vbooking)
    {
        $booking = $vbooking->booking;
        return view('teams.bookings.video.show',compact('booking'));
    }

    public function edit(VendorVideoBooking $vbooking)
    {
        $booking = $vbooking->booking;
        $courses = VideoCourse::where('status','=','Active')->get();
        return view('teams.bookings.video.edit',compact('vbooking','booking','courses'));
    }

    public function update(VendorVideoBooking $vbooking, Request $request)
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

        return redirect('/team/video-bookings')->with('success_message', 'Video Course Booking with ID '.$vbooking->booking_id.' Updated Succesfully.');
    }

    public function destroy(VendorVideoBooking $vbooking)
    {
        $vbooking->booking()->delete();
        $vbooking->delete();
        return redirect('/team/video-bookings')->with('success_message', 'Video Course Booking with ID '.$vbooking->booking_id.' Deleted Succesfully.');
    }
}
