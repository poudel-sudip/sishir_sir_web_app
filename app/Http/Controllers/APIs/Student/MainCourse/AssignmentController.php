<?php

namespace App\Http\Controllers\APIs\Student\MainCourse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Assignments\Assignment;
use App\Models\Assignments\AssignmentAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AssignmentController extends Controller
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

        $assignments = $batch->assignments()->get()
            ->map(function($assignment) {
            $result=AssignmentAnswer::where([
                ['user_id','=',$this->user->id],
                ['assignment_id','=',$assignment->id]
            ])->first() ? true: false;
            
            return (object)[
                'id'=>$assignment->id,
                'question'=>$assignment->question,
                'created_at'=>$assignment->created_at,
                'is_solved'=>$result,
            ];

        });

        return response()->json([
            'assignments' => $assignments,
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

    public function show($id,$assignID)
    {
        $batch = Batch::find($id);
        if(!$batch)
        {
            return response()->json(['error'=>'Course Batch Not Found'], 404);
        }

        $assignment = Assignment::find($assignID);
        if(!$assignment)
        {
            return response()->json(['error'=>'Assignment Not Found'], 404);
        }
       
        return response()->json([
            'assignment_id'=>$assignment->id,
            'assignment_date'=>$assignment->created_at,
            'assignment_question'=>$assignment->question,
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

    public function view($id,$assignID)
    {
        $batch = Batch::find($id);
        if(!$batch)
        {
            return response()->json(['error'=>'Course Batch Not Found'], 404);
        }

        $assignment = Assignment::find($assignID);
        if(!$assignment)
        {
            return response()->json(['error'=>'Assignment Not Found'], 404);
        }

        $result=AssignmentAnswer::where([
            ['user_id','=',$this->user->id],
            ['assignment_id','=',$assignment->id]
        ])->first();

        if(!$result)
        {
            return response()->json(['error'=>'This Assignment Is Not Solved Yet.'], 403);
        }

        return response()->json([
            'assignment_id'=>$assignment->id,
            'assignment_date'=>$assignment->created_at,
            'assignment_question'=>$assignment->question,
            'solution_answer'=>$result->answer,
            'solution_remarks'=>$result->remarks,
            'solution_date'=>$result->created_at,
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

    public function solve($id, $assignID, Request $request)
    {
        $batch = Batch::find($id);
        if(!$batch)
        {
            return response()->json(['error'=>'Course Batch Not Found'], 404);
        }

        $assignment = Assignment::find($assignID);
        if(!$assignment)
        {
            return response()->json(['error'=>'Assignment Not Found'], 404);
        }

        $result=AssignmentAnswer::where([
            ['user_id','=',$this->user->id],
            ['assignment_id','=',$assignment->id]
        ])->first();

        if($result)
        {
            return response()->json(['error'=>'This Assignment Is Already Solved.'], 403);
        }

        $validator=Validator::make($request->all(),[
            'answer'=>'string | required',
        ]);
 
        if($validator->fails()){
            return response()->json([$validator->errors()]);
        }

        $data = AssignmentAnswer::create([
            'user_id'=>$this->user->id,
            'batch_id'=>$batch->id,
            'assignment_id'=>$assignment->id,
            'answer'=>$request->answer,
        ]);

        return response()->json($data);
    }
}
