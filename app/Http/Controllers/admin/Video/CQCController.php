<?php

namespace App\Http\Controllers\admin\Video;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoCourse\VideoCourse;
use App\Models\VideoCourse\VideoCQC;

class CQCController extends Controller
{
    public function index(VideoCourse $course)
    {
        $cqcs = $course->cqcs ;
        return view('admin.videocourse.cqc.index',compact('course','cqcs'));
    }

    public function store(Request $request, VideoCourse $course)
    {
        // dd($request->all());
        $request->validate(["question" => "string|required|min:5"]);
        $course->cqcs()->create([
            'name'=>auth()->user()->name,
            'question' => $request -> question,
        ]);

        return redirect('/admin/video-course/'.$course->id.'/cqc');
    }

    public function destroy(VideoCourse $course, VideoCQC $cqc)
    {
        $cqc->delete();
        return redirect('/admin/video-course/'.$course->id.'/cqc');
    }
}
