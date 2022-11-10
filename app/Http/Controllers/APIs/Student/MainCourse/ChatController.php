<?php

namespace App\Http\Controllers\APIs\Student\MainCourse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
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

    public function index($id)
    {
        $batch = Batch::find($id);
        if(!$batch)
        {
            return response()->json(['error'=>'Course Batch Not Found'], 404);
        }
        $bookings=$batch->bookings()->where('status','=','Verified')->get();
        $students=["Everyone","Admin"];
        foreach ($bookings as $booking)
        {
            $students[] = $booking->user_name;
        }

        $messages = $batch->classDiscussions;
        return response()->json([
            'chat_messages' => $messages,
            'other_students' => $students,
            'other_data'=> [
                'batch'=>$batch->name,
                'course'=>$batch->course->name ?? '',
                'time'=>$batch->schedules()->whereDate('date','>=',date('Y-m-d'))->first()->time ?? $batch->timeSlot ?? '--/-- --',
                'chat'=>url('api/v1/my/course/classroom/'.$batch->id.'/chat'),
                'files'=>url('api/v1/my/course/classroom/'.$batch->id.'/files'),
                'videos'=>url('api/v1/my/course/classroom/'.$batch->id.'/videos'),
                'schedules'=>url('api/v1/my/course/classroom/'.$batch->id.'/schedules'),
                'assignments'=>url('api/v1/my/course/classroom/'.$batch->id.'/assignments'),
                'join_class'=>$batch->classroomLink ?? '',
                'live_class'=>$batch->live_link ?? '',
            ],
        ]);
    }

    public function store($id, Request $request)
    {
        $batch = Batch::find($id);
        if(!$batch)
        {
            return response()->json(['error'=>'Course Batch Not Found'], 404);
        }

        $validator=Validator::make($request->all(),[
            'message'=>'string | required',
            'to'=>'required | string',
        ]);
 
        if($validator->fails()){
            return response()->json([$validator->errors()]);
        }

        $data = $batch->classDiscussions()->create([
            'from'=>$this->user->name,
            'to'=>$request['to'],
            'message'=>$request['message'],
        ]);

        return response()->json($data);
    }

}