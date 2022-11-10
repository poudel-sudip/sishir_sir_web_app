<?php

namespace App\Http\Controllers\admin\Video;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoCourse\VideoCourse;
use App\Models\VideoCourse\VideoChapter;
use App\Models\VideoCourse\VideoPost;

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(VideoCourse $course, VideoChapter $chapter)
    {
        // dd($course,$chapter);
        $videos = $chapter->videos;
        return view('admin.videocourse.video.index',compact('course','chapter','videos'));
    }

    public function create(VideoCourse $course, VideoChapter $chapter)
    {
        return view('admin.videocourse.video.create',compact('course','chapter'));
    }

    public function store(Request $request, VideoCourse $course, VideoChapter $chapter)
    {
        // dd($request->all(),$course,$chapter);
        $request->validate([
            "title" => "string|required",
            "link" => "url|required",
            "description" => "string|required",
            "status" => "string|required",
        ]);

        $chapter->videos()->create([
            'title' => $request->title,
            'link' => $request->link,
            'content' => $request->description,
            'status' => $request->status,
        ]);

        return redirect('/admin/video-course/'.$course->id.'/chapters/'.$chapter->id.'/videos');
    }

    public function show(VideoCourse $course, VideoChapter $chapter, VideoPost $video)
    {
        // dd($course,$chapter,$video);
        return view('admin.videocourse.video.show',compact('course','chapter','video'));
    }

    public function edit(VideoCourse $course, VideoChapter $chapter, VideoPost $video)
    {
        return view('admin.videocourse.video.edit',compact('course','chapter','video'));
    }

    public function update(Request $request, VideoCourse $course, VideoChapter $chapter, VideoPost $video)
    {
        // dd($request->all());
        $request->validate([
            "title" => "string|required",
            "link" => "url|required",
            "description" => "string|required",
            "status" => "string|required",
            "isPublic" => "string|required",
        ]);

        $video->update([
            'title' => $request->title,
            'link' => $request->link,
            'content' => $request->description,
            'status' => $request->status,
            'isPublic' => $request->isPublic,
        ]);
        return redirect('/admin/video-course/'.$course->id.'/chapters/'.$chapter->id.'/videos');
    }

    public function destroy(Request $request, VideoCourse $course, VideoChapter $chapter, VideoPost $video)
    {
        $video->delete();
        return redirect('/admin/video-course/'.$course->id.'/chapters/'.$chapter->id.'/videos');
    }
}
