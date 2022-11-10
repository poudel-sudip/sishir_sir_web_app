<?php

namespace App\Http\Controllers\classroom;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Categories;
use App\Models\Course;
use App\Models\ClassFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\ClassSchedule;
use App\Models\ClassUnit;

class FileController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function fileUnits(Batch $batch)
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
        return view('classroom.fileunits',compact('units','batch','header','headercategories','meeting','todaytime'));
    }

    public function unitFiles(Batch $batch, ClassUnit $unit)
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
        $unitfiles = $unit->classFiles;
        return view('classroom.fileunitfiles',compact('unitfiles','unit','batch','header','headercategories','meeting','todaytime'));
    }

    public function saveUnitFile(Batch $batch, ClassUnit $unit, Request $request)
    {
        // dd($request->all());
        $data=request()->validate([
            'filetitle'=>'string | required',
            'userfile'=>'required | mimes:pdf,docx,doc | max:50000',
        ]);

        $filepath=request('userfile')->store('uploads/files','public');
        $batch->classFiles()->create([
            'unit_id' => $unit->id ?? '',
            'user_id'=>auth()->user()->id,
            'user_name'=>auth()->user()->name,
            'fileTitle'=>$data['filetitle'],
            'filePath'=>$filepath,
        ]);
        
        return redirect('/classroom/files/'.$batch->id.'/unit/'.$unit->id);
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

        return view('classroom.files',compact('batch','header','headercategories','meeting','todaytime'));
    }

    public function store(Batch $batch)
    {
        Gate::authorize('classroom',$batch);

        $data=request()->validate([
            'filetitle'=>'string | required',
            'userfile'=>'required',
        ]);
        $filepath=request('userfile')->store('uploads/files','public');
        $batch->classFiles()->create([
            'user_id'=>auth()->user()->id,
            'user_name'=>auth()->user()->name,
            'fileTitle'=>$data['filetitle'],
            'filePath'=>$filepath,
        ]);
        return redirect('/classroom/files/'.$batch->id.'/all');
    }

    public function view($id)
    {
        return ClassFiles::find($id);
    }

    public function update(Batch $batch, Request $request)
    {
        // dd($request->all());
        $request->validate([
            'file_unit' => 'numeric|nullable',
            'file_id' => 'numeric|required',
            'file_title' => 'string|required',
            'old_file' => 'string|nullable',
            'new_file' => 'nullable|file|mimes:pdf,docx,doc',
        ]);
        $cfile = ClassFiles::where('id','=',$request->file_id)->first();

        if($cfile)
        {
            $fpath = $request->old_file;
            if(isset($request->new_file))
            {
                $fpath = $request['new_file']->store('uploads/files','public');
            }
            $cfile->update([
                'unit_id' => $request->file_unit,
                'user_id'=>auth()->user()->id,
                'user_name'=>auth()->user()->name,
                'fileTitle'=>$request->file_title,
                'filePath'=>$fpath,
            ]);
        }

        if(isset($request->file_unit))
        {
            $red = '/classroom/files/'.$batch->id.'/unit/'.$request->file_unit;
        }
        else
        {
            $red = '/classroom/files/'.$batch->id.'/all';  
        }
        return redirect($red)->with('success','Data Updated Successfully');
    }

    public function destroy(Batch $batch, ClassFiles $file)
    {
        $file->delete();
        return redirect('/classroom/files/'.$batch->id.'/all');
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
