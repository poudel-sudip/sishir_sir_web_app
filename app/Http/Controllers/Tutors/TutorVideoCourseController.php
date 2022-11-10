<?php

namespace App\Http\Controllers\Tutors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TutorVideoCourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tutor = auth()->user()->tutorProfile;
        $courses = $tutor->videoCourses;
        // dd($tutor,$courses);
        return view('tutors.videocourse.index',compact('tutor','courses'));
    }
}
