<?php

namespace App\Http\Controllers\classroom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Batch;
use App\Models\Categories;
use App\Models\Assignments\Assignment;
use App\Models\Assignments\AssignmentAnswer;
use App\Models\ClassSchedule;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Batch $batch)
    {
        Gate::authorize('classroom',$batch);
        if(auth()->user()->role=='Admin'){
            $header='admin.layouts.app';
        }elseif (auth()->user()->role=='Student'){
            $header='student.layouts.app';
        }elseif (auth()->user()->role=='Tutor'){
            $header='tutors.layouts.app';
        }else{
            $header='layouts.app';
        }
        $headercategories=Categories::all()->where('status','=','Active');
        // $meetingID=$batch->meetingID ?? '';
        // $meeting=$this->getmeeting($meetingID);
        $meeting="";

        $todaytime=ClassSchedule::where('batch_id','=',$batch->id)->whereDate('date','=',date('Y-m-d'))->first();

        $assignments=$batch->assignments()->get()
            ->map(function($assignment) {
            $result=AssignmentAnswer::where([
                ['user_id','=',auth()->user()->id],
                ['assignment_id','=',$assignment->id]
            ])->first() ? true: false;
            
            return (object)[
                'question'=>$assignment,
                'status'=>$result,
            ];

        });

        // dd($assignments);
        return view('classroom.assignment',compact('batch','header','headercategories','meeting','assignments','todaytime'));
    }

    public function solve(Batch $batch, Assignment $assignment)
   {
        Gate::authorize('classroom',$batch);
        if(auth()->user()->role=='Admin'){
            $header='admin.layouts.app';
        }elseif (auth()->user()->role=='Student'){
            $header='student.layouts.app';
        }elseif (auth()->user()->role=='Tutor'){
            $header='tutors.layouts.app';
        }else{
            $header='layouts.app';
        }
        $headercategories=Categories::all()->where('status','=','Active');
        $meetingID=$batch->meetingID ?? '';
        $meeting=$this->getmeeting($meetingID);
        $todaytime=ClassSchedule::where('batch_id','=',$batch->id)->whereDate('date','=',date('Y-m-d'))->first();

        // dd($batch,$assignment);
        return view('classroom.solveassignment',compact('batch','header','headercategories','meeting','assignment','todaytime'));
   }

   public function save(Request $request, Batch $batch, Assignment $assignment)
    {
        // dd($batch,$assignment,$request->all());
        $request->validate([
            'answer'=>'required|string'
        ]);

        AssignmentAnswer::create([
            'user_id'=>auth()->user()->id,
            'batch_id'=>$batch->id,
            'assignment_id'=>$assignment->id,
            'answer'=>$request->answer,
        ]);

        return redirect('/classroom/assignments/'.$batch->id);
    }

    public function view(Batch $batch, Assignment $assignment)
    {
        Gate::authorize('classroom',$batch);
        if(auth()->user()->role=='Admin'){
            $header='admin.layouts.app';
        }elseif (auth()->user()->role=='Student'){
            $header='student.layouts.app';
        }elseif (auth()->user()->role=='Tutor'){
            $header='tutors.layouts.app';
        }else{
            $header='layouts.app';
        }
        $headercategories=Categories::all()->where('status','=','Active');
        $meetingID=$batch->meetingID ?? '';
        $meeting=$this->getmeeting($meetingID);
        $todaytime=ClassSchedule::where('batch_id','=',$batch->id)->whereDate('date','=',date('Y-m-d'))->first();

        $answer=AssignmentAnswer::where([
            ['user_id','=',auth()->user()->id],
            ['assignment_id','=',$assignment->id],
        ])->first();

        return view('classroom.assignmentsolution',compact('batch','header','headercategories','meeting','assignment','answer','todaytime'));
    }

    public function store(Request $request, Batch $batch)
    {
        // dd($batch,$request->all());
        $request->validate([
            'question'=>'required|string|min:3'
        ]);

        $batch->assignments()->create([
            'question'=>$request->question
        ]);
        return redirect('/classroom/assignments/'.$batch->id);
    }

    private function getmeeting(string $id)
    {
        $path = 'meetings/' . $id;
        $response = $this->zoomGet($path);
        $meeting=[];
        if($response->status() === 200)
        {
            $data = json_decode($response->body(), true);
            if($data)
            {
                $meeting=(object)[
                    'id'=>$data['id'],
                    'topic'=>$data['topic'],
                    'join_url'=>$data['join_url'],
                    'status'=>$data['status'],
                ];
            }
        }
        return $meeting;
    }

    private function generateZoomToken()
    {
        $key = env('ZOOM_API_KEY', '');
        $secret = env('ZOOM_API_SECRET', '');
        $payload = [
            'iss' => $key,
            'exp' => strtotime('+1 minute'),
        ];
        return \Firebase\JWT\JWT::encode($payload, $secret, 'HS256');
    }

    private function retrieveZoomUrl()
    {
        return env('ZOOM_API_URL', '');
    }

    private function retrieveZoomUser()
    {
        return env('ZOOM_USER', '');
    }

    private function zoomRequest()
    {
        $jwt = $this->generateZoomToken();
        return \Illuminate\Support\Facades\Http::withHeaders([
            'authorization' => 'Bearer ' . $jwt,
            'content-type' => 'application/json',
        ]);
    }

    public function zoomGet(string $path, array $query = [])
    {
        $url = $this->retrieveZoomUrl();
        $request = $this->zoomRequest();
        return $request->get($url . $path, $query);
    }
}
