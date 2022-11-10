<?php

namespace App\Http\Controllers\APIs\Student\MainCourse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Booking;
use App\Models\Batch;
use App\Models\ClassUnit;

class ClassroomController extends Controller
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

    public function index()
    {
        $classes = $this->user->bookings()->where('status','=','Verified')->where('suspended','=',false)->orderBy('id','DESC')->get()->map(function($booking){

            return [
                'booking_id'=>$booking->id,
                'features'=>$booking->features,
                'batch'=>$booking->batch->name ?? '',
                'course'=>$booking->course->name ?? '',
                'status'=>$booking->batch->status ?? '',
                'time'=>$booking->batch->schedules()->whereDate('date','>=',date('Y-m-d'))->first()->time ?? $booking->batch->timeSlot ?? '--/-- --',
                'chat'=>url('api/v1/my/course/classroom/'.$booking->batch_id.'/chat'),
                'files'=>url('api/v1/my/course/classroom/'.$booking->batch_id.'/files'),
                'videos'=>url('api/v1/my/course/classroom/'.$booking->batch_id.'/videos'),
                'schedules'=>url('api/v1/my/course/classroom/'.$booking->batch_id.'/schedules'),
                'assignments'=>url('api/v1/my/course/classroom/'.$booking->batch_id.'/assignments'),
                'mcq_exams'=>url('api/v1/my/course/classroom/'.$booking->batch_id.'/mcq-exams'),
                'written_exams'=>url('api/v1/my/course/classroom/'.$booking->batch_id.'/written-exams'),
                'join_class'=>$booking->batch->classroomLink ?? '',
                'live_class'=>$booking->batch->live_link ?? '',
            ];
        });
        return $classes;
    }

    public function schedules($id)
    {
        $batch = Batch::find($id);
        if(!$batch)
        {
            return response()->json(['error'=>'Course Batch Not Found'], 404);
        }

        $today=date('Y-m-d');
        $schedules = $batch->schedules()->whereDate('date','>=',$today)->get();

        return response()->json([
            'schedules' => $schedules,
            'other_data'=> [
                'batch'=>$batch->name,
                'course'=>$batch->course->name ?? '',
                'time'=>$batch->schedules()->whereDate('date','>=',date('Y-m-d'))->first()->time ?? $batch->timeSlot ?? '--/-- --',
                'chat'=>url('api/v1/my/course/classroom/'.$batch->id.'/chat'),
                'files'=>url('api/v1/my/course/classroom/'.$batch->id.'/files'),
                'videos'=>url('api/v1/my/course/classroom/'.$batch->id.'/videos'),
                'schedules'=>url('api/v1/my/course/classroom/'.$batch->id.'/schedules'),
                'assignments'=>url('api/v1/my/course/classroom/'.$batch->id.'/assignments'),
                'mcq_exams'=>url('api/v1/my/course/classroom/'.$batch->id.'/mcq-exams'),
                'written_exams'=>url('api/v1/my/course/classroom/'.$batch->id.'/written-exams'),
                'join_class'=>$batch->classroomLink ?? '',
                'live_class'=>$batch->live_link ?? '',
            ],
        ]);
    }

    public function unitList($id)
    {
        $batch = Batch::find($id);
        if(!$batch)
        {
            return response()->json(['error'=>'Course Batch Not Found'], 404);
        }

        $units = $batch->units;

        return response()->json([
            'batch_id'=>$batch->id,
            'batch_name'=>$batch->name,
            'course_name'=>$batch->course->name ?? '',
            'units' => $units,
        ]);
    }

    public function unitDetail($id,$uid)
    {
        $batch = Batch::find($id);
        if(!$batch)
        {
            return response()->json(['error'=>'Course Batch Not Found'], 404);
        }

        $unit = ClassUnit::find($uid);
        if(!$unit)
        {
            return response()->json(['error'=>'Course Unit Not Found'], 404);
        }

        $files = $unit->classFiles;
        $videos = $unit->classVideos;
        
        return response()->json([
            'batch_id' => $batch->id,
            'batch_name' => $batch->name,
            'course_name' => $batch->course->name ?? '',
            'unit_id' => $unit->id,
            'unit_name' => $unit->name,
            'unit_slug' => $unit->slug,
            'unit_files' => $files,
            'unit_videos' => $videos,
        ]);
    }
}
