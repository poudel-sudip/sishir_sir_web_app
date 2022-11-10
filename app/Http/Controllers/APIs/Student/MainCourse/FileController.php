<?php

namespace App\Http\Controllers\APIs\Student\MainCourse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\ClassFiles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
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

        $files = $batch->classFiles;
        return response()->json([
            'class_files' => $files,
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

    public function show($id,$fileID)
    {
        $batch = Batch::find($id);
        if(!$batch)
        {
            return response()->json(['error'=>'Course Batch Not Found'], 404);
        }

        $file = ClassFiles::find($fileID);
        if(!$file)
        {
            return response()->json(['error'=>'File Not Found'], 404);
        }

        return response()->json([
            'file' => $file,
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
}
