<?php

namespace App\Http\Controllers\APIs\Student\VideoCourse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\VideoCourse\VideoBooking;

class CQCController extends Controller
{
    protected $user; 

    protected function guard()
    {
        return Auth::guard('api');
    }

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->user=$this->guard()->user();
    }

    public function index($bookingID)
    {
        $booking = VideoBooking::find($bookingID);
        if(!$booking)
        {
            return response()->json(['error'=>'Booking Not Found'], 404);
        }

        if($booking->status != 'Verified')
        {
            return response()->json(['error'=>'This Booking is not Verified. Please Contact Administrator.'], 403);
        }

        $course = $booking->course;
        if(!$course)
        {
            return response()->json(['error'=>'Booked Course Not Found'], 404);
        }

        $cqcs = $course->cqcs()->get(['id','name','question','created_at']);

        return response()->json([
            'course' => [
                'id' => $course->id,
                'name' => $course->name,
                'slug' => $course->slug,
                'thumbnail' => $course->thumbnail,
                'category' => $course->category->name ?? '',
            ],
            'cqc_lists' => $cqcs,
            
        ]);
    }

    public function store($bookingID, Request $request)
    {
        $booking = VideoBooking::find($bookingID);
        if(!$booking)
        {
            return response()->json(['error'=>'Booking Not Found'], 404);
        }

        if($booking->status != 'Verified')
        {
            return response()->json(['error'=>'This Booking is not Verified. Please Contact Administrator.'], 403);
        }

        $course = $booking->course;
        if(!$course)
        {
            return response()->json(['error'=>'Booked Course Not Found'], 404);
        }

        $validator=Validator::make($request->all(),[
            'question'=>'string | required',
        ]);
 
        if($validator->fails()){
            return response()->json([$validator->errors()]);
        }

        $data = $course->cqcs()->create([
            'name'=>$this->user->name,
            'question'=>$request['question'],
        ]);

        return response()->json($data);
    }

}
