<?php

namespace App\Http\Controllers\student\Video;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoCourse\VideoBooking;

class CQCController extends Controller
{
    public function index(VideoBooking $booking)
    {
        $course = $booking->course;
        $cqcs = $course->cqcs;
        // dd($booking,$course,$cqcs);
        return view('student.videocourse.cqc.index',compact('booking','course','cqcs'));
    }

    public function store(Request $request, VideoBooking $booking)
    {
        $course = $booking->course;
        $request->validate(['question'=>'string|required|min:5']);
        $course->cqcs()->create([
            'name'=>auth()->user()->name,
            'question' => $request -> question,
        ]);

        return redirect('/student/video-course/'.$booking->id.'/cqc');
    }
    
}
