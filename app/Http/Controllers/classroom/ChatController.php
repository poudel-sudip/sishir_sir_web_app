<?php

namespace App\Http\Controllers\classroom;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Booking;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Batch $batch)
    {
        Gate::authorize('classroom',$batch);
        if(auth()->user()->role=='Admin'){
            $header='admin.layouts.app';
        }elseif (auth()->user()->role=='Student'){
            $header='student.layouts.app';
        }else{
            $header='layouts.app';
        }

        $bookings=$batch->bookings()->where('status','=','Verified')->get(['id','user_name','user_id']);
        $students=[];
        foreach ($bookings as $booking)
        {
            $students[] = (object)['name'=>$booking->user_name];
        }

        return view('classroom.discussion',compact('batch','header','students'));
    }

    public function store(Batch $batch)
    {
        Gate::authorize('classroom',$batch);
        $data=request()->validate([
            'message'=>'string | required',
            'to'=>'required | string',
        ]);
        $from=auth()->user()->name;
        if(auth()->user()->role=='Admin')
        {
            $from='Admin';
        }

        $batch->classDiscussions()->create([
            'from'=>$from,
            'to'=>$data['to'],
            'message'=>$data['message'],
        ]);
        return redirect('/classroom/chat/'.$batch->id);
    }

}
