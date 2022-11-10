<?php

namespace App\Http\Controllers\admin\Video;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoCourse\VideoCourse;
use App\Models\VideoCourse\VideoChapter;

class ChapterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(VideoCourse $course)
    {
        $chapters = $course->chapters;
        return view('admin.videocourse.chapter.index',compact('chapters','course'));
    }

    public function create(VideoCourse $course)
    {
        return view('admin.videocourse.chapter.create',compact('course'));
    }

    public function store(Request $request, VideoCourse $course)
    {
        // dd($request->all(),$course);
        $request->validate([
            "name" => "string|required",
            "serial" => "numeric|required",
            "status" => "string|required",
        ]);

        $course->chapters()->create([
            'name' => $request->name,
            'sn' => $request->serial,
            'status' => $request->status,
        ]);

        return redirect('/admin/video-course/'.$course->id.'/chapters');
    }

    public function edit(VideoCourse $course, VideoChapter $chapter)
    {
        return view('admin.videocourse.chapter.edit',compact('course','chapter'));
    }

    public function update(Request $request, VideoCourse $course, VideoChapter $chapter)
    {
        // dd($request->all());
        $request->validate([
            "name" => "string|required",
            "serial" => "numeric|required",
            "status" => "string|required",
        ]);

        $chapter->update([
            'name' => $request->name,
            'sn' => $request->serial,
            'status' => $request->status,
        ]);

        return redirect('/admin/video-course/'.$course->id.'/chapters');
    }

    public function destroy(Request $request, VideoCourse $course, VideoChapter $chapter)
    {
        $chapter->videos()->delete();
        $chapter->delete();
        return redirect('/admin/video-course/'.$course->id.'/chapters');
    }
}
