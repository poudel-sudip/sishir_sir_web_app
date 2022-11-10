<?php

namespace App\Http\Controllers\Zoom;

use App\Models\Batch;
use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class MeetingController extends Controller
{
    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;

    public function list(Request $request) 
    { 
        /**/ 
        Gate::authorize('permission','zoom');
        $path = 'users/'.$this->retrieveZoomUser().'/meetings';
        $response = $this->zoomGet($path);
        $data = json_decode($response->body(), true);
       
        if(!$response->ok())
        {
            dd('Error => Zoom Api Error');
        }
        $meetings=$data['meetings'];
        
        $result = array_map(function($m)
        {  
            if($m['type']==1){
                $type='INSTANT';
            }
            elseif($m['type']==2){
                $type='SCHEDULED';
            }
            elseif($m['type']==3){
                $type='RECURRING';
            }
            else{
                $type='FIXED RECURRING';
            }
            $batchtime=Batch::where('meetingID','=',$m['id'])->first()->timeSlot ?? '-';
            return array_merge($m,[
                'type'=>$type,
                'time'=>$batchtime,
            ]);
        },$meetings);  

        return view('admin.zoom.meetinglist',[
            'meetings'=>$result,
        ]);
    }

    public function add()
    {
        Gate::authorize('permission','zoom');
        return view('admin.zoom.meetingcreate',[
            'courses'=>Course::all()->where('status','=','Active'),
        ]);
    }

    public function create(Request $request) 
    { 
        /**/ 
        Gate::authorize('permission','zoom');
        $data=$request->validate([
            'course_name' => 'numeric|min:1',
            'batch_name' => 'numeric|min:1',
            'meetingtype' => 'numeric|min:1',
            'time' => 'required|string',
            'agenda' => 'string|nullable',

        ]);
        $course=Course::find($data['course_name'])->name ?? 'Course Name';
        $batch=Batch::find($data['batch_name']);
        $topic=$course.' '.$batch->name;
        
        $path = 'users/'.$this->retrieveZoomUser().'/meetings';
        $response = $this->zoomPost($path, [
            'topic' => $topic,
            'type' => $data['meetingtype'],
            'duration' => 30,
            'agenda' => $data['agenda'],
            'settings' => [
                'host_video' => true,
                'participant_video' => false,
                'waiting_room' => true,
            ]
        ]);

        if($response->status() === 201)
        {
            $response=json_decode($response->body(), true);
            $meetingID=$response['id'];
            $batch->update([
                'meetingID'=>$meetingID,
                'timeSlot'=>$data['time'],
            ]);
        }
        
        return redirect('/admin/zoom/meetings');
    }

    public function get(Request $request, string $id)
    { 
        /**/ 

        $path = 'meetings/' . $id;
        $response = $this->zoomGet($path);

        $data = json_decode($response->body(), true);
        // if ($response->ok()) {
        //     // $data['start_at'] = $this->toUnixTimeStamp($data['start_time'], $data['timezone']);
        // }
        if($data['type']==1){
            $type='INSTANT';
        }
        elseif($data['type']==2){
            $type='SCHEDULED';
        }
        elseif($data['type']==3){
            $type='RECURRING';
        }
        else{
            $type='FIXED RECURRING';
        }

        $batchtime=Batch::where('meetingID','=',$data['id'])->first()->timeSlot ?? '-';
        $result=(object)[
            'id'=>$data['id'],
            'topic'=>$data['topic'],
            'type'=>$type,
            'status'=>$data['status'],
            'start_url'=>$data['start_url'],
            'join_url'=>$data['join_url'],
            'batch_time'=>$batchtime,
        ];
        // dd($result);
        return view('admin.zoom.meetingshow',[
            'meeting'=>$result,
        ]);
        
    }

    public function edit(Request $request, string $id) 
    {
        Gate::authorize('permission','zoom');
        $path = 'meetings/' . $id;
        $response = $this->zoomGet($path);

        $data = json_decode($response->body(), true);
        // if ($response->ok()) {
        //     // $data['start_at'] = $this->toUnixTimeStamp($data['start_time'], $data['timezone']);
        // }
        if($data['type']==1){
            $type='INSTANT';
        }
        elseif($data['type']==2){
            $type='SCHEDULED';
        }
        elseif($data['type']==3){
            $type='RECURRING';
        }
        else{
            $type='FIXED RECURRING';
        }

        $batchtime=Batch::where('meetingID','=',$data['id'])->first()->timeSlot ?? '-';
        $result=(object)[
            'id'=>$data['id'],
            'topic'=>$data['topic'],
            'type'=>$type,
            'status'=>$data['status'],
            'start_url'=>$data['start_url'],
            'join_url'=>$data['join_url'],
            'batch_time'=>$batchtime,
        ];

        return view('admin.zoom.meetingedit',[
            'meeting'=>$result,
            'courses'=>Course::all()->where('status','=','Active'),
        ]);
    }

    public function update(Request $request, string $id) 
    {
        /**/ 
        Gate::authorize('permission','zoom');
        $data = $request->validate([
            'meetingId' => 'required|string',
            'course_name' => 'required|numeric|min:1',
            'batch_name' => 'required|numeric|min:1',
            'timeSlot' => 'required|string',
        ]);
        $course=Course::find($data['course_name'])->name ?? 'Course Name';
        $batches=Batch::where('meetingId','=',$id)->update(['meetingId'=>'','timeSlot'=>'']);
        $batch=Batch::find($data['batch_name']);
        $topic=$course.' '.$batch->name;
        $batch->update([
            'meetingID'=>$data['meetingId'],
            'timeSlot'=>$data['timeSlot']
        ]);
    
        $path = 'meetings/' . $id;
        $response = $this->zoomPatch($path, [
            'topic' => $topic,
            'settings' => [
                'host_video' => true,
                'participant_video' => false,
                'waiting_room' => true,
            ]
        ]);
        
        return redirect('/admin/zoom/meetings');
        
    }

    public function delete(Request $request, string $id)
    {
        /**/ 
        Gate::authorize('permission','zoom');
        $path = 'meetings/' . $id;
        $response = $this->zoomDelete($path);
        
        return redirect('/admin/zoom/meetings');
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

    public function zoomPost(string $path, array $body = [])
    {
        $url = $this->retrieveZoomUrl();
        $request = $this->zoomRequest();
        return $request->post($url . $path, $body);
    }

    public function zoomPatch(string $path, array $body = [])
    {
        $url = $this->retrieveZoomUrl();
        $request = $this->zoomRequest();
        return $request->patch($url . $path, $body);
    }

    public function zoomDelete(string $path, array $body = [])
    {
        $url = $this->retrieveZoomUrl();
        $request = $this->zoomRequest();
        return $request->delete($url . $path, $body);
    }

    public function toZoomTimeFormat(string $dateTime)
    {
        try {
            $date = new \DateTime($dateTime);
            return $date->format('Y-m-d\TH:i:s');
        } catch(\Exception $e) {
            Log::error('ZoomJWT->toZoomTimeFormat : ' . $e->getMessage());
            return '';
        }
    }

    public function toUnixTimeStamp(string $dateTime, string $timezone)
    {
        try {
            $date = new \DateTime($dateTime, new \DateTimeZone($timezone));
            return $date->getTimestamp();
        } catch (\Exception $e) {
            Log::error('ZoomJWT->toUnixTimeStamp : ' . $e->getMessage());
            return '';
        }
    }

}
