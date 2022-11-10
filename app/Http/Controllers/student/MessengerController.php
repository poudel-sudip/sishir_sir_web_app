<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class MessengerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $groups = auth()->user()->bookings()->where('status','=','Verified')->where('suspended','=',false)->orderBy('id','DESC')->get()->map(function($booking){
            
            return (object)[
                'id' => $booking->id,
                'image' => $booking->course->image ?? '',
                'course' => $booking->course->name ?? '',
                'batch' => $booking->batch->name ?? '',
            ];
        });
        // dd($groups);
        return view('student.messenger.chatgroups',compact('groups'));
    }

    public function chatShow($id)
    {
        $booking = Booking::find($id);
        if(!$booking)
        {
            abort(404,"oops...Not Found");
        }
        $batch = $booking->batch;
        if(!$batch)
        {
            abort(404,'oops...Not Found');
        }
        $user =  auth()->user();

        $groups = $user->bookings()->where('status','=','Verified')->where('suspended','=',false)->orderBy('id','DESC')->get()->map(function($booking){
            
            return (object)[
                'id' => $booking->id,
                'image' => $booking->course->image ?? '',
                'course' => $booking->course->name ?? '',
                'batch' => $booking->batch->name ?? '',
            ];
        });

        $chats = $batch->classDiscussions;
        return view('student.messenger.chatshow',compact('booking','batch','groups','chats'));
    }

    public function chatSave($id, Request $request)
    {
        $booking = Booking::find($id);
        if(!$booking)
        {
            abort(404,"oops...Not Found");
        }
        $batch = $booking->batch;
        if(!$batch)
        {
            abort(404,'oops...Not Found');
        }

        $request->validate(["message"=>"required|string"]);
        $batch->classDiscussions()->create([
            'from'=>auth()->user()->name,
            'to'=>'Everyone',
            'message'=>$request['message'],
        ]);

        return redirect('/student/messenger/'.$booking->id.'/chat');
    }

}
