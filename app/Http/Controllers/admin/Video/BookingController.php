<?php

namespace App\Http\Controllers\admin\Video;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoCourse\VideoCourse;
use App\Models\VideoCourse\VideoBooking;
use App\Models\User;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bookings = VideoBooking::all()->sortByDesc('id')->take(300);
        return view('admin.videocourse.booking.index',compact('bookings'));
    }

    public function allBookings()
    {
        $bookings = VideoBooking::all()->sortByDesc('id');
        return view('admin.videocourse.booking.allbookings',compact('bookings'));
    }

    public function create()
    {
        $courses= VideoCourse::where('status','=','Active')->get();
        return view('admin.videocourse.booking.create',compact('courses'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "course_name" => "numeric|required",
            "userid" => "numeric|required",
            "verificationMode" => "string|required",
            "paymentAmount" => "numeric|required",
            "discount" => "numeric|nullable",
            "remarks" => "string|nullable",
            "status" => "string|required",
            "verificationDocument" => "image|nullable",
        ]);

        $user = User::find($request->userid);
        if(!$user)
        {
            return back()->withInput()->withErrors(['userid'=>'User Not Found. Please Check User ID.']);
        } 
        $course = VideoCourse::find($request->course_name);

        $search=VideoBooking::where([
            ['course_id','=',$request['course_name']],
            ['user_id','=',$request['userid']],
            ])->count();
        if($search){
            return back()->withInput()->withErrors(['course_name'=>'This Course is Already Booked by the Given User. Please Check Again !!!']);
        }

        $due = (integer)(($course->fee - $course->discount) - ($request->paymentAmount + $request->discount));
        $img = '';
        if(isset($request->verificationDocument))
        {
            $img = request('verificationDocument')->store('uploads','public');
        }

        VideoBooking::create([
            'course_id' => $course->id,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'status' => $request->status,
            'updatedBy' => auth()->user()->name,
            'verificationMode' => $request->verificationMode,
            'paymentAmount' => $request->paymentAmount,
            'discount' => $request->discount ?? 0,
            'dueAmount' => $due,
            'verificationDocument' => $img,
            'remarks' => $request->remarks,
        ]);

        return redirect('/admin/video-booking');
    }

    public function show(VideoBooking $booking)
    {
        return view('admin.videocourse.booking.show',compact('booking'));
    }

    public function edit(VideoBooking $booking)
    {
        $courses = VideoCourse::where('status','=','Active')->get();
        return view('admin.videocourse.booking.edit',compact('booking','courses'));
    }

    public function update(Request $request, VideoBooking $booking)
    {
        // dd($request->all());
        $request->validate([
            "course_name" => "numeric|required",
            "verificationMode" => "string|required",
            "paymentAmount" => "numeric|required",
            "discount" => "numeric|nullable",
            "remarks" => "string|nullable",
            "status" => "string|required",
            "uploadDocument" => "image|nullable",
            "oldDocument" => "string|nullable",
            "trans_code" => "string|nullable",
        ]);
        $course = VideoCourse::find($request->course_name);
        $due = (integer)(($course->fee - $course->discount) - ($request->paymentAmount + $request->discount));
        $img=$request->oldDocument;
        if(isset($request->uploadDocument))
        {
            $img=request('uploadDocument')->store('uploads','public');
        }

        $booking->update([
            'course_id' => $request->course_name,
            'status' => $request->status,
            'updatedBy' => auth()->user()->name,
            'verificationMode' => $request->verificationMode,
            'paymentAmount' => $request->paymentAmount,
            'discount' => $request->discount ?? 0,
            'dueAmount' => $due,
            'verificationDocument' => $img,
            'remarks' => $request->remarks,
            'trans_code' => $request->trans_code,
        ]);

        return redirect('/admin/video-booking');
    }

    public function destroy(VideoBooking $booking)
    {
        $booking->vendorBooking()->delete();
        $booking->delete();
        return redirect('/admin/video-booking');
    }
}
