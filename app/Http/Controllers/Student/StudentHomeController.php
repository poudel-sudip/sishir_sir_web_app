<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;
use App\Models\OpenExams\OpenExam;

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
                // 'courses'=>$user->bookings()->count(),
                // 'classroom'=>$user->bookings()->where([['status','=','Verified'],['suspended','=',false]])->count(),
                'exams'=>$user->exam_bookings()->count(),
                'pdf_banks'=>$user->ebook_bookings()->count(),
            ],
            'free_exams' => (object)[
                'count' => OpenExam::where('result_status','=','Unpublished')->count(),
                'link' => '/student/free-exams',
            ],
        ];
        
        // $posts=Blog::all()->where('status','=','Published')->sortByDesc('id')->take(25);
        // dd($count);
        return view('student.home',compact('user','count'));
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

    public function freeExamList(Request $request)
    {
        $data['free_exams'] = OpenExam::where('result_status','=','Unpublished')
        ->get()
        ->sortByDesc('id')
        ->values();

        return view('student.examhall.free.list',$data);
    }

}
