<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\FreeVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FreeVideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.freeVideos.index',[
           'videos'=>FreeVideo::all()->sortByDesc('id'),
        ]);
    }

    public function create()
    {
        Gate::authorize('permission','video');
        return view('admin.freeVideos.create',[]);
    }

    public function store(Request $request)
    {
        Gate::authorize('permission','video');
        $request->validate([
           'title'=>'string',
           'link'=>'string',
           'description'=>'',
        ]);

        $url=$request->link;
        $id="";

        if(strpos($url,"youtube"))
        {
            if(strpos($url,"&"))
            {
                $id = substr($url,strpos($url,"?v=")+3,strpos($url,"&")-(strpos($url,"?v=")+3));
            }
            else
            {
                $id = substr($url,strpos($url,"?v=")+3,strlen($url));
            }
        }

        FreeVideo::create([
            'title'=>$request->title,
            'link'=>$request->link,
            'video_id'=>$id,
            'description'=>$request->description,
        ]);

        return redirect('/admin/free-videos');
    }

    public function destroy(FreeVideo $video)
    {
        Gate::authorize('permission','video');
        $video->delete();
        return redirect('/admin/free-videos');
    }



}
