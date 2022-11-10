<?php

namespace App\Http\Controllers\classroom\TutorCourse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tutors\SpecialCourse;
use App\Models\Tutors\TutorClassVideo;

class VideoController extends Controller
{
    public function index(SpecialCourse $course)
    {

        if(auth()->user()->role=='Admin'){
            $header='admin.layouts.app';
        }elseif (auth()->user()->role=='Student'){
            $header='student.layouts.app';
        }elseif (auth()->user()->role=='Tutor'){
            $header='tutors.layouts.app';
        }else{
            $header='layouts.app';
        }

        return view('specialCourseClassroom.videos',compact('course','header'));
    }

    public function store(SpecialCourse $course)
    {

        $data=request()->validate([
            'videotitle'=>'string | required',
            'uservideo'=>'string | required',
        ]);
        $course->videos()->create([
            'user_id'=>auth()->user()->id,
            'user_name'=>auth()->user()->name,
            'videoTitle'=>$data['videotitle'],
            'videoPath'=>$data['uservideo'],
        ]);
        return redirect('/special-course/classroom/videos/'.$course->id);
    }

    public function destroy(SpecialCourse $course, TutorClassVideo $video)
    {
        $video->delete();
        return redirect('/special-course/classroom/videos/'.$course->id);
    }
}
