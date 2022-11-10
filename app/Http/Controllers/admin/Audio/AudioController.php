<?php

namespace App\Http\Controllers\admin\Audio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\Audio\AudioCategory;
use App\Models\Audio\AudioFile;

class AudioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(AudioCategory $category)
    {
        $audios = $category->audios;
        return view('admin.audios.audio.index',compact('category','audios'));
    }

    public function upload(AudioCategory $category)
    {
        return view('admin.audios.audio.upload',compact('category'));
    }

    public function store(Request $request, AudioCategory $category)
    {
        $request->validate([
            'file' => 'required|max:5120|mimes:mp3,ogg',
        ]);
        $mime=explode("/",request()->file->getClientmimeType())[1];
        $orginal=explode('.'.$mime,request()->file->getClientOriginalName())[0];

        $slug = Str::slug($orginal);
        $name = $slug.'-'.time().'.'.$mime;
        // dd($request->all(),$orginal,$mime,$name);
        $request->file->move(public_path('uploads/audios'), $name);
        $category->audios()->create([
            'filename'=>$name,
            'url'=>url('uploads/audios/'.$name),
        ]);

        return response()->json(['success'=>'Successfully uploaded.']);
    }

    public function destroy(AudioCategory $category, AudioFile $audio)
    {
        // dd($category,$audio);
        $audio->delete();
        return redirect('/admin/audios/'.$category->id.'/files');
    }
}
