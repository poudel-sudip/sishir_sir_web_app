<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $videos=Video::all();
        return view('admin.videos.index',compact('videos'));
    }

    public function upload()
    {
        Gate::authorize('permission','video');
        return view('admin.videos.upload');
    }

    public function store(Request $request)
    {
        Gate::authorize('permission','video');
        $request->validate([
            'file' => 'required',
        ]);
        $mime=explode("/",request()->file->getClientmimeType())[1];
        $orginal=explode('.'.$mime,request()->file->getClientOriginalName())[0];

        $slug = Str::slug($orginal);
        $name = Carbon::now()->format('y-m-d-').$slug.'.'.$mime;
        // dd($request->all(),$orginal,$mime,$name);
        $request->file->move(public_path('uploads/videos'), $name);
        Video::create([
            'filename'=>$name,
            'url'=>url('uploads/videos/'.$name),
            'author'=>auth()->user()->name,
        ]);

        return response()->json(['success'=>'Successfully uploaded.']);


    }

    public function destroy(Video $video)
    {
        Gate::authorize('permission','video');
        $filepath='uploads/videos/'.$video->filename;
        File::delete($filepath);
        $video->delete();
        return redirect('/admin/videos');
    }
}
