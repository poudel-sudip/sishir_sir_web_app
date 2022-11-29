<?php

namespace App\Http\Controllers\classroom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\ClassUnit;
use App\Models\Batch;
use App\Models\ClassVideos;

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
        }else{
            $header='layouts.app';
        }
        $units = $batch->units;
        // dd($units);
        return view('classroom.videounits',compact('units','batch','header'));
    }

    public function videoUnitsVideos(Batch $batch, ClassUnit $unit)
    {
        // dd($batch,$unit);
        Gate::authorize('classroom',$batch);

        if(auth()->user()->role=='Admin'){
            $header='admin.layouts.app';
        }elseif (auth()->user()->role=='Student'){
            $header='student.layouts.app';
        }else{
            $header='layouts.app';
        }
        $videos = $unit->classVideos;
        return view('classroom.videounitvideos',compact('videos','unit','batch','header'));
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
        }else{
            $header='layouts.app';
        }

        return view('classroom.videos',compact('batch','header'));
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
   
}
