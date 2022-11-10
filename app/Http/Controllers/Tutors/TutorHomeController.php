<?php

namespace App\Http\Controllers\Tutors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TutorPost;

class TutorHomeController extends Controller
{
    public function index()
    {
        $batches=auth()->user()->tutorProfile->batches->count() ?? 0;
        $specialcourses=auth()->user()->tutorProfile->specialCourses->count() ?? 0;
        $post=auth()->user()->tutorProfile->posts->count() ?? 0;
        $count=(object)[
            'classes'=>$batches,
            'specialClasses'=>$specialcourses,
            'post'=>$post,
        ];
        $post=TutorPost::all()->where('status','=','Published')->sortByDesc('id')->take(25);
        return view('tutors.home',compact('count','post'));
    }
    public function addComments(TutorPost $post,Request $request)
    {
         // dd($request->all());
         $request->validate([
             'name'=>['required','string'],
             'email'=>['required','email'],
             'contact'=>['required','numeric','digits:10'],
             'message'=>['required','string'],
         ]);
 
         $post->comments()->create([
             'post_id'=>$post->id,
             'name'=>$request->name,
             'email'=>$request->email,
             'contact'=>$request->contact,
             'message'=>$request->message,
             'status'=>'Published',
         ]);
 
         return redirect('/tutor/home');
    }


    public function classroom()
    {
        $batches=auth()->user()->tutorProfile->batches;
        return view('tutors.classroom',compact('batches'));
    }

    public function reviews()
    {
        $tutor=auth()->user()->tutorProfile;
        return view('tutors.reviews',compact('tutor'));
    }
}
