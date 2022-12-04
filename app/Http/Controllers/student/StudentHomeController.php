<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;

class StudentHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user=auth()->user();

        $count= (object) [
            'bookings'=> (object) [
                'courses'=>$user->bookings()->count(),
                'classroom'=>$user->bookings()->where([['status','=','Verified'],['suspended','=',false]])->count(),
                'exams'=>$user->exam_bookings()->count(),
                'ebooks'=>$user->ebook_bookings()->count(),
            ],
        ];
        
        $posts=Blog::all()->where('status','=','Published')->sortByDesc('id')->take(25);
        // dd($count);
        return view('student.home',compact('user','count','posts'));
    }

    public function addComments(Blog $post,Request $request)
    {
         // dd($request->all());
         $request->validate([
             'name'=>['required','string'],
             'email'=>['required','email'],
             'contact'=>['required','numeric','digits:10'],
             'message'=>['required','string'],
         ]);
 
         $post->comments()->create([
             'name'=>$request->name,
             'email'=>$request->email,
             'contact'=>$request->contact,
             'message'=>$request->message,
             'status'=>'Published',
         ]);
 
         return redirect('/student/home');
    }

    

}
