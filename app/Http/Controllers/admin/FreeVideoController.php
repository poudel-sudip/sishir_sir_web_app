<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FreeVideo;
use Illuminate\Http\Request;

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
        return view('admin.freeVideos.create',[]);
    }

    public function store(Request $request)
    {
        $request->validate([
           'title'=>'string',
           'link'=>'string',
        //    'description'=>'',
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

        // dd($request->all, $url, $id);

        FreeVideo::create([
            'title'=>$request->title,
            'link'=>$request->link,
            'video_id'=>$id,
            // 'description'=>$request->description,
        ]);

        return redirect('/admin/free-videos');
    }

    public function destroy(FreeVideo $video)
    {
        $video->delete();
        return redirect('/admin/free-videos');
    }



}
