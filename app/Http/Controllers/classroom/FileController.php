<?php

namespace App\Http\Controllers\classroom;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\ClassFiles;
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
        }else{
            $header='layouts.app';
        }
        $units = $batch->units;
        // dd($units);
        return view('classroom.fileunits',compact('units','batch','header'));
    }

    public function unitFiles(Batch $batch, ClassUnit $unit)
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
        $unitfiles = $unit->classFiles;
        return view('classroom.fileunitfiles',compact('unitfiles','unit','batch','header'));
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
        }else{
            $header='layouts.app';
        }

        return view('classroom.files',compact('batch','header'));
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
 
}
