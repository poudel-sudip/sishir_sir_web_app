<?php

namespace App\Http\Controllers\admin\Video;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoCourse\VideoCourse;
use App\Models\VideoCourse\VideoTutor;
use App\Models\Tutor;

class TutorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(VideoCourse $course)
    {
        $tutors=$course->tutors;
        return view('admin.videocourse.tutor.index',compact('course','tutors'));
    }

    public function create(VideoCourse $course)
    {
        $tutors = Tutor::all();
        return view('admin.videocourse.tutor.create',compact('course','tutors'));
    }

    public function store(Request $request, VideoCourse $course)
    {
        // dd($request->all());
        $request->validate(['tutor'=>'numeric|required|min:1']);
        $course->tutors()->create([
            'tutor_id' => $request->tutor,
        ]);

        return redirect('/admin/video-course/'.$course->id.'/tutors');
    }

    public function edit(VideoCourse $course, VideoTutor $tutor)
    {
        return view('admin.videocourse.tutor.edit',compact('course','tutor'));
    }

    public function update(Request $request, VideoCourse $course, VideoTutor $tutor)
    {
        // dd($request->all(),$course,$tutor);
        $request->validate([
            "name" => "required|string",
            "percent" => "required|numeric",
            "paidAmount" => "required|numeric",
        ]);

        $tutor->update([
            'percent' => $request->percent,
            'paidAmount' => $request->paidAmount,
        ]);

        return redirect('/admin/video-course/'.$course->id.'/tutors');

    }

    public function destroy(VideoCourse $course, VideoTutor $tutor)
    {
        $tutor->delete();
        return redirect('/admin/video-course/'.$course->id.'/tutors');
    }
}
