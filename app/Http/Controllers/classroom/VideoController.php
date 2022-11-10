<?php

namespace App\Http\Controllers\classroom;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Categories;
use App\Models\ClassVideos;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\ClassSchedule;
use App\Models\ClassUnit;

class VideoController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function videoUnits(Batch $batch)
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
        $meeting="";
        $headercategories=[];
        $todaytime=ClassSchedule::where('batch_id','=',$batch->id)->whereDate('date','=',date('Y-m-d'))->first();
        $units = $batch->units;
        // dd($units);
        return view('classroom.videounits',compact('units','batch','header','headercategories','meeting','todaytime'));
    }

    public function videoUnitsVideos(Batch $batch, ClassUnit $unit)
    {
        // dd($batch,$unit);
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
        $meeting="";
        $headercategories=[];
        $todaytime=ClassSchedule::where('batch_id','=',$batch->id)->whereDate('date','=',date('Y-m-d'))->first();
        $videos = $unit->classVideos;
        return view('classroom.videounitvideos',compact('videos','unit','batch','header','headercategories','meeting','todaytime'));
    }

    public function savevideoUnitsVideo(Batch $batch, ClassUnit $unit, Request $request)
    {
        // dd($request->all());
        $data=request()->validate([
            'videotitle'=>'string | required',
            'uservideo'=>'string | required',
        ]);
        $batch->classVideos()->create([
            'unit_id' => $unit->id ?? '',
            'user_id'=>auth()->user()->id,
            'user_name'=>auth()->user()->name,
            'videoTitle'=>$data['videotitle'],
            'videoPath'=>$data['uservideo'],
        ]);

        return redirect('/classroom/videos/'.$batch->id.'/unit/'.$unit->id);
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
        // $meetingID=$batch->meetingID ?? '';
        // $meeting=$this->getmeeting($meetingID);
        $meeting="";
        $todaytime=ClassSchedule::where('batch_id','=',$batch->id)->whereDate('date','=',date('Y-m-d'))->first();

        return view('classroom.videos',compact('batch','header','headercategories','meeting','todaytime'));
    }

    public function store(Batch $batch)
    {
        Gate::authorize('classroom',$batch);

        $data=request()->validate([
            'videotitle'=>'string | required',
            'uservideo'=>'string | required',
        ]);
        $batch->classVideos()->create([
            'user_id'=>auth()->user()->id,
            'user_name'=>auth()->user()->name,
            'videoTitle'=>$data['videotitle'],
            'videoPath'=>$data['uservideo'],
        ]);
        return redirect('/classroom/videos/'.$batch->id.'/all');
    }


    public function destroy(Batch $batch, ClassVideos $video)
    {
        $video->delete();
        return redirect('/classroom/videos/'.$batch->id.'/all');
    }

    
    public function update(Request $request, Batch $batch)
    {
        // dd($request->all(),$batch);
        $request->validate([
            'video_unit' => 'numeric|nullable',
            'video_id' => 'numeric|required',
            'video_title' => 'string|required',
            'video_url' => 'string|required',
        ]);
        $video = ClassVideos::where('id','=',$request->video_id)->first();
        if($video)
        {
            $video->update([
                'unit_id' => $request->video_unit,
                'user_id'=>auth()->user()->id,
                'user_name'=>auth()->user()->name,
                'videoTitle'=>$request->video_title,
                'videoPath'=>$request->video_url,
            ]);
        }
        if(isset($request->video_unit))
        {
            $red = '/classroom/videos/'.$batch->id.'/unit/'.$request->video_unit;
        }
        else
        {
            $red = '/classroom/videos/'.$batch->id.'/all';  
        }
        return redirect($red)->with('success','Data Updated Successfully');
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
