<?php

namespace App\Http\Controllers\classroom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Tutor;
use App\Models\ClassSchedule;

class ScheduleController extends Controller
{
    public function index(Batch $batch)
    {
        $today=date('Y-m-d');
        $schedules=ClassSchedule::where('batch_id','=',$batch->id)->whereDate('date','>=',$today)->get();
        return view('admin.batches.schedules.index',compact('batch','schedules'));
    }

    public function classroomindex(Batch $batch)
    {
        $today=date('Y-m-d');
        $schedules=ClassSchedule::where('batch_id','=',$batch->id)->whereDate('date','>=',$today)->orderBy('date')->get();

        if(auth()->user()->role=='Admin'){
            $header='admin.layouts.app';
        }elseif (auth()->user()->role=='Student'){
            $header='student.layouts.app';
        }elseif (auth()->user()->role=='Tutor'){
            $header='tutors.layouts.app';
        }else{
            $header='layouts.app';
        }
        $todaytime=ClassSchedule::where('batch_id','=',$batch->id)->whereDate('date','=',$today)->first();
        // $meetingID=$batch->meetingID ?? '';
        // $meeting=$this->getmeeting($meetingID);
        $meeting="";
    
        return view('classroom.schedules',compact('batch','header','meeting','schedules','todaytime'));
    }

    public function create(Batch $batch)
    {
        $tutors=Tutor::all();
        return view('admin.batches.schedules.create',compact('batch','tutors'));
    }

    public function store(Request $request,Batch $batch)
    {
        // dd($request->all(),$batch);
        $request->validate([
            'tutor'=>'string|required',
            'topic'=>'string|required',
            'date'=>'date|required',
            'time'=>'string|required',
        ]);

        ClassSchedule::create([
            'batch_id'=>$batch->id,
            'date'=>$request->date,
            'tutor'=>$request->tutor,
            'topic'=>$request->topic,
            'time'=>$request->time,
        ]);

        return redirect('/admin/batches/'.$batch->id.'/schedules');
    }

    public function destroy(Batch $batch, ClassSchedule $schedule)
    {
        // dd($batch,$schedule);
        $schedule->delete();
        return redirect('/admin/batches/'.$batch->id.'/schedules');
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
