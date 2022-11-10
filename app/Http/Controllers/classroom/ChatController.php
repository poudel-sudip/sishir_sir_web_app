<?php

namespace App\Http\Controllers\classroom;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Booking;
use App\Models\Categories;
use App\Models\Course;
use App\Models\PrivateChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\ClassSchedule;

class ChatController extends Controller
{
    //
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
        }elseif (auth()->user()->role=='Tutor'){
            $header='tutors.layouts.app';
        }else{
            $header='layouts.app';
        }
        $headercategories=Categories::all()->where('status','=','Active');
        $bookings=$batch->bookings()->where('status','=','Verified')->get();
        $students=[];
        foreach ($bookings as $booking)
        {
            $students[] = (object)['name'=>$booking->user_name];
        }
        // $meetingID=$batch->meetingID ?? '';
        // $meeting=$this->getmeeting($meetingID);
        $meeting="";
        $todaytime=ClassSchedule::where('batch_id','=',$batch->id)->whereDate('date','=',date('Y-m-d'))->first();

        return view('classroom.discussion',compact('batch','header','headercategories','students','meeting','todaytime'));
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
        if(auth()->user()->role=='Tutor')
        {
            $from=$from.'(Tutor)';
        }
        $batch->classDiscussions()->create([
            'from'=>$from,
            'to'=>$data['to'],
            'message'=>$data['message'],
        ]);
        return redirect('/classroom/chat/'.$batch->id);
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
